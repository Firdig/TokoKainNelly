<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. All-time stats
        $totalRevenueAllTime = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrdersAllTime = Order::where('status', '!=', 'cancelled')->count();

        // 2. This month's stats
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalRevenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        // 3. Chart Data: Last 30 Days Sales
        $chartData = [];
        $chartLabels = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $dbDate = $date->toDateString();

            $dailyRevenue = Order::whereDate('created_at', $dbDate)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
            
            $chartData[] = $dailyRevenue;
        }

        // 4. Paginated Orders (Filtered by optional search/date)
        $query = Order::with(['user', 'items'])
            ->where('status', '!=', 'cancelled')
            ->latest();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if ($request->has('type') && in_array($request->type, ['pos', 'bops', 'delivery'])) {
            $query->ofType($request->type);
        }

        $orders = $query->paginate(20);

        return view('admin.sales-report.index', compact(
            'totalRevenueAllTime',
            'totalOrdersAllTime',
            'totalRevenueThisMonth',
            'chartLabels',
            'chartData',
            'orders'
        ));
    }
}
