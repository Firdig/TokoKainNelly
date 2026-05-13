<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::today()->startOfDay();

        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::today()->endOfDay();

        $baseQuery = Order::where('status', '!=', 'cancelled')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $paymentSummary = (clone $baseQuery)
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total_amount')
            ->get();

        $grandTotal = $paymentSummary->sum('total_amount');
        $grandCount = $paymentSummary->sum('transaction_count');

        $paymentLabels = [
            'cash'     => 'Tunai',
            'edc_bca'  => 'EDC BCA',
            'edc_bni'  => 'EDC BNI',
            'qris'     => 'QRIS Statis',
            'transfer' => 'Transfer',
            'midtrans' => 'Online (Midtrans)',
            'cod'      => 'Bayar di Toko (COD)',
        ];

        $missingRefOrders = (clone $baseQuery)
            ->whereIn('payment_method', ['edc_bca', 'edc_bni', 'qris'])
            ->where(function ($q) {
                $q->whereNull('payment_reference')->orWhere('payment_reference', '');
            })
            ->with('user')
            ->latest()
            ->get();

        return view('admin.payment-report.index', compact(
            'paymentSummary',
            'grandTotal',
            'grandCount',
            'paymentLabels',
            'startDate',
            'endDate',
            'missingRefOrders'
        ));
    }
}
