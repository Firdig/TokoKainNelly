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
     * Cancel an order if it is still in 'pending' status (Diterima)
     * or has not been paid yet (Menunggu Pembayaran).
     * Per AD-19: Once the order moves to 'in_preparation' or beyond it cannot be cancelled.
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // AD-19: Allow cancellation only when status is 'pending' OR payment is still pending.
        // Block when order is already being prepared (in_preparation) or later stages.
        $isCancellable = $order->status === 'pending' || $order->isPaymentPending();
        $isAlreadyClosed = in_array($order->status, ['cancelled', 'completed']);

        if ($isAlreadyClosed) {
            return back()->with('error', 'Pesanan ini sudah ' . ($order->status === 'cancelled' ? 'dibatalkan' : 'selesai') . '.');
        }

        if (!$isCancellable) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sedang diproses atau sudah dikirim.');
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

        $order->update([
            'status'         => 'cancelled',
            'payment_status' => $order->isPaymentPending() ? 'cancelled' : $order->payment_status,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
