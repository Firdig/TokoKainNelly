<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * API controller for admin real-time notifications.
 *
 * Provides endpoints for AJAX polling to check for new orders
 * and refresh the order table without full page reload.
 */
class AdminNotificationController extends Controller
{
    /**
     * Check for new orders since last poll and return current pending counts.
     *
     * Used by the admin layout's polling JS to display toast notifications
     * and update badge counters across all admin pages.
     *
     * @param  Request $request  Expects optional 'last_check' ISO timestamp
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $lastCheck = $request->query('last_check');

        // Current pending order counts (paid only)
        $pendingCount = Order::where('status', 'pending')
            ->whereIn('transaction_type', ['bops', 'delivery'])
            ->where('payment_status', 'paid')
            ->count();

        $pendingBops = Order::where('status', 'pending')
            ->where('transaction_type', 'bops')
            ->where('payment_status', 'paid')
            ->count();

        $pendingDelivery = Order::where('status', 'pending')
            ->where('transaction_type', 'delivery')
            ->where('payment_status', 'paid')
            ->count();

        // Fetch new orders since last check
        $newOrders = [];
        if ($lastCheck) {
            try {
                $since = \Carbon\Carbon::parse($lastCheck);

                $newOrders = Order::whereIn('transaction_type', ['bops', 'delivery'])
                    ->where('payment_status', 'paid')
                    ->where(function ($q) use ($since) {
                        // Orders created after last check
                        $q->where('created_at', '>', $since)
                          // Or orders that became paid after last check
                          ->orWhere('paid_at', '>', $since);
                    })
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(fn (Order $order) => [
                        'id'               => $order->id,
                        'invoice_number'   => $order->invoice_number,
                        'customer_name'    => $order->customer_name ?? 'Pelanggan',
                        'transaction_type' => $order->transaction_type,
                        'total_amount'     => $order->total_amount,
                        'created_at'       => $order->created_at->format('d M Y, H:i'),
                    ]);
            } catch (\Exception $e) {
                // Invalid timestamp, return empty
                $newOrders = [];
            }
        }

        return response()->json([
            'pending_count'    => $pendingCount,
            'pending_bops'     => $pendingBops,
            'pending_delivery' => $pendingDelivery,
            'new_orders'       => $newOrders,
            'server_time'      => now()->toIso8601String(),
        ]);
    }

    /**
     * Return rendered HTML rows for the admin orders table.
     *
     * Called via AJAX when admin is on /admin/orders page to refresh
     * the table content without a full page reload.
     *
     * @param  Request $request  Supports 'type' and 'status' filters
     * @return \Illuminate\Http\Response  HTML partial
     */
    public function orderTableRows(Request $request)
    {
        $query = Order::with(['items.productVariant.product', 'user', 'processedBy'])
            ->whereIn('transaction_type', ['bops', 'delivery', 'pos'])
            ->whereNotIn('payment_status', ['unpaid', 'pending'])
            ->latest();

        // Filter by transaction type
        if ($request->has('type') && in_array($request->type, ['bops', 'delivery', 'pos'])) {
            $query->ofType($request->type);
        }

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'in_preparation', 'ready_for_pickup', 'shipped', 'completed', 'cancelled'])) {
            $query->ofStatus($request->status);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders._order-rows', compact('orders'));
    }
}
