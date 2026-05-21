<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Pusat Laporan — Controller gabungan untuk semua laporan admin.
 *
 * Menggabungkan logika dari:
 * - SalesReportController        (Tab: Penjualan)
 * - ProductSalesReportController (Tab: Penjualan Per Produk)
 * - StockReportController        (Tab: Pergerakan Stok)
 * - AssetReportController        (Tab: Nilai Aset)
 * - PaymentReportController      (Tab: Rekapitulasi Pembayaran)
 */
class ReportCenterController extends Controller
{
    public function index(Request $request)
    {
        // Determine active tab (default: sales)
        $activeTab = $request->input('tab', 'sales');

        // ═══════════════════════════════════════════════════════════════
        // TAB 1: PENJUALAN KESELURUHAN
        // ═══════════════════════════════════════════════════════════════

        // All-time stats
        $salesTotalRevenueAllTime = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $salesTotalOrdersAllTime  = Order::where('status', '!=', 'cancelled')->count();

        // This month stats
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();
        $salesTotalRevenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        // Chart: Last 30 days
        $salesChartData   = [];
        $salesChartLabels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesChartLabels[] = $date->format('d M');
            $salesChartData[]   = Order::whereDate('created_at', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
        }

        // Paginated orders with optional filters
        $salesQuery = Order::with(['user', 'items'])
            ->where('status', '!=', 'cancelled')
            ->latest();

        if ($request->has('sales_start_date') && $request->has('sales_end_date')) {
            $salesQuery->whereBetween('created_at', [
                Carbon::parse($request->sales_start_date)->startOfDay(),
                Carbon::parse($request->sales_end_date)->endOfDay(),
            ]);
        }
        if ($request->has('sales_type') && in_array($request->sales_type, ['pos', 'bops', 'delivery'])) {
            $salesQuery->ofType($request->sales_type);
        }
        $salesOrders = $salesQuery->paginate(20, ['*'], 'sales_page')->withQueryString();

        // ═══════════════════════════════════════════════════════════════
        // TAB 2: PENJUALAN PER PRODUK
        // ═══════════════════════════════════════════════════════════════

        $psDateFrom = $request->input('ps_date_from');
        $psDateTo   = $request->input('ps_date_to');
        $psSearch   = $request->input('ps_search');

        $psQuery = Product::select('products.*')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                     ->where('orders.status', '!=', 'cancelled');
            })
            ->groupBy('products.id');

        if ($psDateFrom) {
            $psQuery->where(function ($q) use ($psDateFrom) {
                $q->whereNull('orders.id')
                  ->orWhereDate('orders.created_at', '>=', $psDateFrom);
            });
        }
        if ($psDateTo) {
            $psQuery->where(function ($q) use ($psDateTo) {
                $q->whereNull('orders.id')
                  ->orWhereDate('orders.created_at', '<=', $psDateTo);
            });
        }
        if ($psSearch) {
            $psQuery->where('products.name', 'like', "%{$psSearch}%");
        }

        $psProducts = $psQuery
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
            ->selectRaw('COUNT(DISTINCT orders.id) as order_count')
            ->orderByDesc('total_sold')
            ->paginate(20, ['*'], 'ps_page')
            ->withQueryString();

        $psProducts->load('variants');

        // Chart: Top 10 products
        $psTopProducts = Product::select('products.id', 'products.name')
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->join('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                     ->where('orders.status', '!=', 'cancelled');
            })
            ->when($psDateFrom, fn($q) => $q->whereDate('orders.created_at', '>=', $psDateFrom))
            ->when($psDateTo, fn($q) => $q->whereDate('orders.created_at', '<=', $psDateTo))
            ->groupBy('products.id', 'products.name')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $psChartLabels = $psTopProducts->pluck('name')->toArray();
        $psChartData   = $psTopProducts->pluck('total_sold')->toArray();

        // ═══════════════════════════════════════════════════════════════
        // TAB 3: PERGERAKAN STOK
        // ═══════════════════════════════════════════════════════════════

        $stockVariantId    = $request->input('stock_variant_id');
        $stockDateFrom     = $request->input('stock_date_from');
        $stockDateTo       = $request->input('stock_date_to');
        $stockMovementType = $request->input('stock_movement_type');

        $stockQuery = StockMovement::with(['productVariant.product', 'createdBy'])
            ->orderByDesc('created_at');

        if ($stockVariantId)    $stockQuery->where('product_variant_id', $stockVariantId);
        if ($stockDateFrom)     $stockQuery->whereDate('created_at', '>=', $stockDateFrom);
        if ($stockDateTo)       $stockQuery->whereDate('created_at', '<=', $stockDateTo);
        if ($stockMovementType) $stockQuery->where('movement_type', $stockMovementType);

        // Summary
        $stockSummaryQ = StockMovement::query()
            ->when($stockVariantId,    fn($q) => $q->where('product_variant_id', $stockVariantId))
            ->when($stockDateFrom,     fn($q) => $q->whereDate('created_at', '>=', $stockDateFrom))
            ->when($stockDateTo,       fn($q) => $q->whereDate('created_at', '<=', $stockDateTo))
            ->when($stockMovementType, fn($q) => $q->where('movement_type', $stockMovementType));

        $stockTotalKeluar = abs((float) (clone $stockSummaryQ)->where('quantity', '<', 0)->sum('quantity'));
        $stockTotalMasuk  = (float) (clone $stockSummaryQ)->where('quantity', '>', 0)->sum('quantity');
        $stockTotalCount  = (clone $stockSummaryQ)->count();

        $stockMovements = $stockQuery->paginate(25, ['*'], 'stock_page')->withQueryString();

        $stockVariants = ProductVariant::with('product')->orderBy('product_id')->get();
        $stockMovementTypes = [
            'sale_pos'          => 'Penjualan Kasir',
            'sale_online'       => 'Penjualan Online',
            'opname_adjustment' => 'Penyesuaian Audit',
            'manual_addition'   => 'Penambahan Manual',
            'return'            => 'Retur Barang',
        ];

        // ═══════════════════════════════════════════════════════════════
        // TAB 4: NILAI ASET INVENTARIS
        // ═══════════════════════════════════════════════════════════════

        $assetTotal = ProductVariant::join('products', 'product_variants.product_id', '=', 'products.id')
            ->sum(DB::raw('product_variants.stock * products.price'));

        $assetProducts = Product::with('variants', 'category')
            ->get()
            ->map(function ($product) {
                $product->total_stock = $product->variants->sum('stock');
                $product->asset_value = $product->total_stock * $product->price;
                return $product;
            })
            ->sortByDesc('asset_value');

        $assetCategories = $assetProducts->groupBy(fn($p) => $p->category?->name ?? 'Tanpa Kategori')
            ->map(function ($items, $categoryName) {
                return [
                    'name'          => $categoryName,
                    'product_count' => $items->count(),
                    'total_stock'   => $items->sum('total_stock'),
                    'asset_value'   => $items->sum('asset_value'),
                ];
            })
            ->sortByDesc('asset_value')
            ->values();

        // ═══════════════════════════════════════════════════════════════
        // TAB 5: REKAPITULASI PEMBAYARAN
        // ═══════════════════════════════════════════════════════════════

        $payStartDate = $request->filled('pay_start_date')
            ? Carbon::parse($request->pay_start_date)->startOfDay()
            : Carbon::today()->startOfDay();
        $payEndDate = $request->filled('pay_end_date')
            ? Carbon::parse($request->pay_end_date)->endOfDay()
            : Carbon::today()->endOfDay();

        $payBaseQuery = Order::where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$payStartDate, $payEndDate]);

        $paySummary = (clone $payBaseQuery)
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total_amount')
            ->get();

        $payGrandTotal = $paySummary->sum('total_amount');
        $payGrandCount = $paySummary->sum('transaction_count');

        $payLabels = [
            'cash'     => 'Tunai',
            'edc_bca'  => 'EDC BCA',
            'edc_bni'  => 'EDC BNI',
            'qris'     => 'QRIS Statis',
            'transfer' => 'Transfer',
            'midtrans' => 'Online (Midtrans)',
            'cod'      => 'Bayar di Toko (COD)',
        ];

        $payMissingRefOrders = (clone $payBaseQuery)
            ->whereIn('payment_method', ['edc_bca', 'edc_bni', 'qris'])
            ->where(function ($q) {
                $q->whereNull('payment_reference')->orWhere('payment_reference', '');
            })
            ->with('user')
            ->latest()
            ->get();

        // ═══════════════════════════════════════════════════════════════
        // RETURN VIEW
        // ═══════════════════════════════════════════════════════════════

        return view('admin.report-center.index', compact(
            'activeTab',
            // Tab 1: Penjualan
            'salesTotalRevenueAllTime', 'salesTotalOrdersAllTime', 'salesTotalRevenueThisMonth',
            'salesChartLabels', 'salesChartData', 'salesOrders',
            // Tab 2: Per Produk
            'psProducts', 'psChartLabels', 'psChartData', 'psDateFrom', 'psDateTo', 'psSearch',
            // Tab 3: Stok
            'stockMovements', 'stockVariants', 'stockMovementTypes',
            'stockTotalKeluar', 'stockTotalMasuk', 'stockTotalCount',
            'stockVariantId', 'stockDateFrom', 'stockDateTo', 'stockMovementType',
            // Tab 4: Aset
            'assetTotal', 'assetProducts', 'assetCategories',
            // Tab 5: Pembayaran
            'paySummary', 'payGrandTotal', 'payGrandCount', 'payLabels',
            'payStartDate', 'payEndDate', 'payMissingRefOrders',
        ));
    }
}
