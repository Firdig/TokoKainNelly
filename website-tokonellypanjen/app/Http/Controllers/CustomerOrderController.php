<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for customer order tracking.
 * Allows authenticated customers to view their order history and details.
 */
class CustomerOrderController extends Controller
{
    /**
     * Display the customer's order history list.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.productVariant.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a single order's details with tracking information.
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.productVariant.product')
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order if it is still in 'pending' status (Menunggu Konfirmasi).
     * Once the admin confirms the order (moves to 'in_preparation' / Diproses),
     * the customer can no longer cancel.
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $isAlreadyClosed = in_array($order->status, ['cancelled', 'completed']);

        if ($isAlreadyClosed) {
            return back()->with('error', 'Pesanan ini sudah ' . ($order->status === 'cancelled' ? 'dibatalkan' : 'selesai') . '.');
        }

        // Allow cancellation only when status is 'pending' (before admin confirms).
        // Once the order moves to 'in_preparation' or beyond, it cannot be cancelled.
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah dikonfirmasi dan sedang diproses.');
        }

        // Return stock
        try {
            $inventoryService = app(\App\Services\InventoryService::class);
            $inventoryService->restoreStockForCancelledOrder($order, null);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to restore stock for customer cancelled order', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        // Refund payment if the order has already been paid via Midtrans
        $refundSuccess = false;
        $wasPaidViaMidtrans = $order->isPaid() && $order->usesMidtrans();

        if ($wasPaidViaMidtrans) {
            try {
                $midtransService = app(\App\Services\MidtransService::class);
                $refundSuccess = $midtransService->refundOrder($order);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Refund failed during order cancellation', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        // Determine new payment status
        $newPaymentStatus = $order->payment_status;
        if ($refundSuccess) {
            $newPaymentStatus = 'refunded';
        } elseif ($order->isPaymentPending()) {
            $newPaymentStatus = 'cancelled';
        }

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => $newPaymentStatus,
        ]);

        // Show appropriate message based on refund result
        if ($refundSuccess) {
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan. Dana akan dikembalikan ke metode pembayaran Anda.');
        } elseif ($wasPaidViaMidtrans && !$refundSuccess) {
            return redirect()->route('orders.index')->with('warning', 'Pesanan berhasil dibatalkan, namun pengembalian dana gagal diproses otomatis. Silakan hubungi admin untuk pengembalian dana.');
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
