<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Service class for generating sales reports.
 * Extracts report logic from controllers to maintain thin controller pattern.
 */
class ReportService
{
    /**
     * Get daily sales report data for a given date.
     *
     * @param  \Carbon\Carbon|null $date  The date to report on (defaults to today)
     * @return array{orders: Collection, totalRevenue: float, totalTransactions: int, date: Carbon}
     */
    public function getDailySalesReport(?Carbon $date = null): array
    {
        $date = $date ?? Carbon::today();

        $orders = Order::with(['items.productVariant.product'])
            ->whereDate('created_at', $date)
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->get();

        return [
            'orders'            => $orders,
            'totalRevenue'      => $orders->sum('total_amount'),
            'totalTransactions' => $orders->count(),
            'date'              => $date,
        ];
    }

    /**
     * Get sales summary for the last N days (for dashboard charts).
     *
     * @param  int $days  Number of days to look back
     * @return array<string, float>  Date label => revenue amount
     */
    public function getSalesSummary(int $days = 7): array
    {
        $summary = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $label = $date->format('d M');
            $dbDate = $date->toDateString();

            $summary[$label] = Order::whereDate('created_at', $dbDate)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
        }

        return $summary;
    }
}
