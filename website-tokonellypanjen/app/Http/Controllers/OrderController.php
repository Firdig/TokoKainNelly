<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Admin controller for managing orders (Delivery, BOPS, and POS).
 * Supports filtering by transaction type and status updates.
 */
class OrderController extends Controller
{
    /**
     * Display all orders in admin panel with optional type filter.
     * Uses Eager Loading to prevent N+1 query problem.
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.productVariant.product', 'user'])->latest();

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
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,ready_for_pickup,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', "Status Pesanan #{$order->invoice_number} berhasil diperbarui menjadi {$validated['status']}.");
    }
}
