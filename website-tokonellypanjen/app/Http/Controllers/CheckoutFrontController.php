<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Handles the E-Commerce checkout flow for online customers.
 * Delegates business logic to CheckoutService (thin controller pattern).
 */
class CheckoutFrontController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService
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

            return redirect()->route('checkout.success', $order->id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the order success / invoice page.
     */
    public function success($id)
    {
        $order = Order::with('items.productVariant.product')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}
