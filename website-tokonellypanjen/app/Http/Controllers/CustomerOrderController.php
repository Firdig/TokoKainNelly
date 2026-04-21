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
}
