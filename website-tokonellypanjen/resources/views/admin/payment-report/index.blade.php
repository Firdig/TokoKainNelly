@extends('layouts.admin')

@section('title', 'Laporan Rekapitulasi Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div>
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Laporan Rekapitulasi Pembayaran</h2>
        <p class="mt-1 text-sm text-slate-500">Ringkasan transaksi per metode pembayaran untuk rekonsiliasi dengan laporan bank dan penyelenggara QRIS.</p>
    </div>

    <!-- Filter Periode -->
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6">
        <form method="GET" action="{{ route('admin.payment-report.index') }}" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->toDateString() }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->toDateString() }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
            </div>
            <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Tampilkan</button>
            <a href="{{ route('admin.payment-report.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-bold text-sm transition-all">Hari Ini</a>
            <button type="button" onclick="window.print()" class="ml-auto bg-brand-600 hover:bg-brand-700 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Pendapatan Periode</p>
            <p class="text-3xl font-black text-brand-900">Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
            <p class="text-sm text-slate-500 mt-1">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi</p>
            <p class="text-3xl font-black text-brand-900">{{ number_format($grandCount) }} <span class="text-sm font-medium text-slate-500">transaksi</span></p>
        </div>
    </div>

    <!-- Tabel Rekapitulasi Per Metode Pembayaran -->
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Rekapitulasi Per Metode Pembayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Metode Pembayaran</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Jumlah Transaksi</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total Nominal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($paymentSummary as $row)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-brand-900 text-sm">
                                {{ $paymentLabels[$row->payment_method] ?? ucfirst(str_replace('_', ' ', $row->payment_method)) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ number_format($row->transaction_count) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-brand-600">Rp{{ number_format($row->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-500">
                                {{ $grandTotal > 0 ? number_format(($row->total_amount / $grandTotal) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada data transaksi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($paymentSummary->isNotEmpty())
                <tfoot class="bg-brand-50">
                    <tr>
                        <td class="px-6 py-4 font-bold text-brand-900 text-sm">Total</td>
                        <td class="px-6 py-4 text-center font-bold text-brand-900 text-sm">{{ number_format($grandCount) }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">100%</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Transaksi Tanpa Nomor Referensi -->
    @if($missingRefOrders->isNotEmpty())
    <div class="bg-amber-50 rounded-3xl shadow-sm border border-amber-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-amber-200 bg-amber-100/50 flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
            <h3 class="font-outfit font-bold text-lg text-amber-900">Transaksi Tanpa Nomor Referensi ({{ $missingRefOrders->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-amber-200">
                <thead class="bg-amber-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-amber-700 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-amber-700 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-amber-700 uppercase">Metode</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-amber-700 uppercase">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100 bg-white">
                    @foreach($missingRefOrders as $order)
                        <tr>
                            <td class="px-6 py-3 text-sm font-bold text-brand-900">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-brand-600 hover:underline">{{ $order->invoice_number }}</a>
                            </td>
                            <td class="px-6 py-3 text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-3 text-center text-sm">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">
                                    {{ $paymentLabels[$order->payment_method] ?? $order->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right text-sm font-bold text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
