<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders as total_spent' => fn($q) => $q->where('status', '!=', 'cancelled')], 'total_amount');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(20)->withQueryString();

        $totalCustomers = User::where('role', 'customer')->count();

        return view('admin.customers.index', compact('customers', 'totalCustomers'));
    }

    public function show(User $customer)
    {
        $customer->loadCount('orders');

        $orders = Order::where('user_id', $customer->id)
            ->with('items.productVariant.product')
            ->latest()
            ->paginate(10);

        $totalSpent = Order::where('user_id', $customer->id)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        return view('admin.customers.show', compact('customer', 'orders', 'totalSpent'));
    }
}
