<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controller for POS page display and daily reports.
 * Report logic is delegated to ReportService.
 */
class WebController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService
    ) {}

    /**
     * Display the POS (Point of Sale) cashier interface.
     * Eager loads products with variants to prevent N+1 queries.
     */
    public function pos()
    {
        $products = Product::whereHas('variants')
            ->with('variants')
            ->get();

        return view('pos', compact('products'));
    }

    /**
     * Display the daily sales report.
     * Business logic is delegated to ReportService.
     */
    public function laporan(Request $request)
    {
        $date = $request->filled('date')
            ? Carbon::parse($request->date)
            : Carbon::today();

        $report = $this->reportService->getDailySalesReport($date);

        return view('laporan', [
            'orders'    => $report['orders'],
            'totalOmzet' => $report['totalRevenue'],
            'hariIni'   => $report['date'],
        ]);
    }
}
