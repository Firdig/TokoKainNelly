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
     * Cancel an order if it's still pending or unpaid.
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!$order->isPaymentPending()) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan karena sudah dibayar atau diproses.');
        }

        // Return stock
        try {
            // Using existing logic similar to MidtransService cancel
            $inventoryService = app(\App\Services\InventoryService::class);
            $inventoryService->restoreStockForCancelledOrder($order, null);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to restore stock for customer cancelled order', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        $order->update([
            'status' => 'cancelled',
            'payment_status' => $order->isPaymentPending() ? 'cancelled' : $order->payment_status,
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
