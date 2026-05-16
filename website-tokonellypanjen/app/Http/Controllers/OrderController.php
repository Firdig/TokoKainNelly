<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Admin controller for managing orders (Delivery, BOPS, and POS).
 * Supports filtering by transaction type and status updates.
 */
class OrderController extends Controller
{
    /**
     * Display incoming orders (Delivery & BOPS only) in admin panel.
     * Per AD-12: POS orders and unpaid/pending-payment orders are excluded.
     * Supports optional ?type filter (bops / delivery).
     */
    public function index(Request $request)
    {
        // AD-12: Only show Delivery, BOPS, and POS orders
        $query = Order::with(['items.productVariant.product', 'user'])
            ->whereIn('transaction_type', ['bops', 'delivery', 'pos'])
            // AD-12: Exclude orders still awaiting payment confirmation
            ->whereNotIn('payment_status', ['unpaid', 'pending'])
            ->latest();

        if ($request->has('type') && in_array($request->type, ['bops', 'delivery', 'pos'])) {
            $query->ofType($request->type);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the status of an order (e.g., pending → ready_for_pickup).
     * Uses Form Request-style inline validation.
     */
    public function updateStatus(Request $request, Order $order, \App\Services\InventoryService $inventoryService)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_preparation,ready_for_pickup,shipped,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $validated['status']]);

        // Restore stock if the order is cancelled
        if ($oldStatus !== 'cancelled' && $validated['status'] === 'cancelled') {
            $inventoryService->restoreStockForCancelledOrder($order, \Illuminate\Support\Facades\Auth::id() ?? 1);
        }

        // Send email notification to customer if they have an account
        if ($order->user && $order->user->email && $oldStatus !== $validated['status']) {
            Mail::to($order->user->email)->queue(
                new OrderStatusUpdatedMail($order, $oldStatus, $validated['status'])
            );
        }

        return redirect()->back()
            ->with('success', "Status Pesanan #{$order->invoice_number} berhasil diperbarui menjadi {$validated['status']}.");
    }

    /**
     * Show order details.
     */
    public function show(Order $order)
    {
        $order->load(['items.productVariant.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Print Picking Slip for BOPS/Delivery
     */
    public function pickingSlip(Order $order)
    {
        $order->load(['items.productVariant.product', 'user']);
        return view('admin.orders.picking-slip', compact('order'));
    }
}
