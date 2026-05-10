<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\Order;
use App\Services\CheckoutService;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

/**
 * Handles the E-Commerce checkout flow for online customers.
 * Delegates business logic to CheckoutService (thin controller pattern).
 * Supports Midtrans online payments and COD.
 */
class CheckoutFrontController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
        private readonly MidtransService $midtransService,
    ) {}

    /**
     * Display the checkout page with cart summary.
     */
    public function index()
    {
        $sessionId = Session::get('cart_id');
        $cart = Cart::with('items.productVariant.product')
            ->where('session_id', $sessionId)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/katalog')->with('error', 'Keranjang Anda masih kosong.');
        }

        return view('checkout.index', compact('cart'));
    }

    /**
     * Process the E-Commerce checkout using validated CheckoutRequest.
     * Uses CheckoutService with pessimistic locking for stock safety.
     *
     * For Midtrans payments: creates order → generates Snap token → redirects to payment page.
     * For COD payments: creates order → redirects directly to success page.
     */
    public function process(CheckoutRequest $request)
    {
        $sessionId = Session::get('cart_id');
        $cart = Cart::with('items.productVariant.product')
            ->where('session_id', $sessionId)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/katalog')->with('error', 'Keranjang Anda masih kosong.');
        }

        try {
            $order = $this->checkoutService->processEcommerceCheckout(
                cartItems: $cart->items,
                transactionType: $request->validated('transaction_type'),
                paymentMethod: $request->validated('payment_method'),
                userId: Auth::id(),
                customerInfo: [
                    'name'    => $request->validated('customer_name'),
                    'phone'   => $request->validated('customer_phone'),
                    'address' => $request->validated('delivery_address'),
                ]
            );

            // Clear the cart after successful checkout
            $cart->items()->delete();

            // Send order confirmation email
            if (Auth::user() && Auth::user()->email) {
                Mail::to(Auth::user()->email)->queue(new OrderConfirmationMail($order));
            }

            // Route based on payment method
            if ($order->payment_method === 'midtrans') {
                // Generate Midtrans Snap token and redirect to payment page
                try {
                    $this->midtransService->createSnapToken($order);
                    return redirect()->route('checkout.payment', $order->id);
                } catch (\Exception $e) {
                    Log::error('Midtrans Snap token failed, falling back to success page', [
                        'order_id' => $order->id,
                        'error'    => $e->getMessage(),
                    ]);
                    return redirect()->route('checkout.success', $order->id)
                        ->with('warning', 'Pesanan berhasil dibuat, namun halaman pembayaran tidak dapat dimuat. Silakan hubungi admin.');
                }
            }

            // COD: go directly to success page
            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the Midtrans Snap payment page.
     * Allows customer to pay or re-attempt payment for an unpaid order.
     */
    public function payment($id)
    {
        $order = Order::with('items.productVariant.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // If already paid, redirect to success
        if ($order->isPaid()) {
            return redirect()->route('checkout.success', $order->id)
                ->with('info', 'Pesanan ini sudah dibayar.');
        }

        // If no snap token yet, or token might be expired, generate a new one
        if (empty($order->snap_token)) {
            try {
                $this->midtransService->createSnapToken($order);
                $order->refresh();
            } catch (\Exception $e) {
                Log::error('Failed to create Snap token on payment page', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
                return redirect()->route('checkout.success', $order->id)
                    ->with('error', 'Gagal memuat halaman pembayaran. Silakan coba lagi atau hubungi admin.');
            }
        }

        $clientKey = config('midtrans.client_key');
        $snapUrl   = config('midtrans.snap_url');

        return view('checkout.payment', compact('order', 'clientKey', 'snapUrl'));
    }

    /**
     * Display the order success / invoice page.
     */
    public function success($id)
    {
        $order = Order::with('items.productVariant.product')->findOrFail($id);

        // Fetch latest status from Midtrans if it's still unpaid/pending but uses Midtrans
        if ($order->usesMidtrans() && $order->isPaymentPending() && $order->snap_token) {
            try {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                
                $midtransStatus = \Midtrans\Transaction::status($order->invoice_number);
                
                if ($midtransStatus && isset($midtransStatus->transaction_status)) {
                    // Update locally by simulating the webhook payload structure
                    $payload = (array) $midtransStatus;
                    $payload['signature_key'] = hash('sha512', 
                        ($payload['order_id'] ?? '') . 
                        ($payload['status_code'] ?? '') . 
                        ($payload['gross_amount'] ?? '') . 
                        config('midtrans.server_key')
                    );
                    
                    app(\App\Services\MidtransService::class)->handleNotification($payload);
                    $order->refresh();
                }
            } catch (\Exception $e) {
                // Ignore if transaction not found in Midtrans yet
                \Illuminate\Support\Facades\Log::info('Midtrans status check info: ' . $e->getMessage());
            }
        }

        $clientKey = config('midtrans.client_key');
        $snapUrl   = config('midtrans.snap_url');

        return view('checkout.success', compact('order', 'clientKey', 'snapUrl'));
    }
}
