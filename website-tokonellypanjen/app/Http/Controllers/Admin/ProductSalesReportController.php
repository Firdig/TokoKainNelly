<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSalesReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');
        $search   = $request->input('search');

        $query = Product::select('products.*')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                     ->where('orders.status', '!=', 'cancelled');
            })
            ->groupBy('products.id');

        if ($dateFrom) {
            $query->where(function ($q) use ($dateFrom) {
                $q->whereNull('orders.id')
                  ->orWhereDate('orders.created_at', '>=', $dateFrom);
            });
        }

        if ($dateTo) {
            $query->where(function ($q) use ($dateTo) {
                $q->whereNull('orders.id')
                  ->orWhereDate('orders.created_at', '<=', $dateTo);
            });
        }

        if ($search) {
            $query->where('products.name', 'like', "%{$search}%");
        }

        $products = $query
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
            ->selectRaw('COUNT(DISTINCT orders.id) as order_count')
            ->orderByDesc('total_sold')
            ->paginate(20)
            ->withQueryString();

        // Load variants for stock info
        $products->load('variants');

        // Chart: top 10 best-selling products
        $topProducts = Product::select('products.id', 'products.name')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                     ->where('orders.status', '!=', 'cancelled');
            })
            ->when($dateFrom, fn($q) => $q->whereDate('orders.created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('orders.created_at', '<=', $dateTo))
            ->groupBy('products.id', 'products.name')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $chartLabels = $topProducts->pluck('name')->toArray();
        $chartData   = $topProducts->pluck('total_sold')->toArray();

        return view('admin.product-sales-report.index', compact(
            'products',
            'chartLabels',
            'chartData',
            'dateFrom',
            'dateTo',
            'search'
        ));
    }
}
