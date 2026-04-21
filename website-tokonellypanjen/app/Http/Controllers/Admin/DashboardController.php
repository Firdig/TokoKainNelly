<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\ReportService;
use Illuminate\Support\Facades\DB;

/**
 * Admin dashboard controller showing key business metrics.
 * Uses ReportService for sales data and eager loading to prevent N+1 queries.
 */
class DashboardController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService
    ) {}

    /**
     * Display the admin dashboard with stats, charts, and alerts.
     */
    public function index()
    {
        // Total asset value (stock × price across all variants)
        $totalAssets = ProductVariant::join('products', 'product_variants.product_id', '=', 'products.id')
            ->sum(DB::raw('product_variants.stock * products.price'));

        $totalProducts = Product::count();

        // Pending online orders (delivery + BOPS)
        $pendingOrders = Order::ofStatus('pending')
            ->whereIn('transaction_type', ['bops', 'delivery'])
            ->count();

        // Low stock alert: variants with ≤ 10m stock
        $lowStockProducts = ProductVariant::with('product')
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->get();

        // Sales chart data (last 7 days) — via ReportService
        $monthlySales = $this->reportService->getSalesSummary(7);

        return view('admin.dashboard', compact(
            'totalAssets',
            'totalProducts',
            'pendingOrders',
            'lowStockProducts',
            'monthlySales'
        ));
    }
}
