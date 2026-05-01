@extends('layouts.admin')

@section('title', 'Laporan Penjualan Keseluruhan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div>
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Laporan Penjualan Keseluruhan</h2>
        <p class="mt-1 text-sm text-slate-500">Ringkasan performa penjualan dari semua kanal (Online, BOPS, dan Kasir).</p>
    </div>

    <!-- Top Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Omzet (All-Time)</p>
            <p class="text-3xl font-black text-brand-900 relative z-10">Rp{{ number_format($totalRevenueAllTime, 0, ',', '.') }}</p>
        </div>
        
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Omzet Bulan Ini</p>
            <p class="text-3xl font-black text-brand-900 relative z-10">Rp{{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi</p>
            <p class="text-3xl font-black text-brand-900 relative z-10">{{ number_format($totalOrdersAllTime, 0, ',', '.') }} <span class="text-sm font-medium text-slate-500">pesanan</span></p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 p-6">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6">Tren Penjualan (30 Hari Terakhir)</h3>
        <div class="w-full h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Filter and Table Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Riwayat Transaksi</h3>
            
            <form method="GET" action="{{ route('admin.sales-report.index') }}" class="flex flex-wrap gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
                <span class="text-slate-500 self-center">s/d</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
                
                <select name="type" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
                    <option value="">Semua Kanal</option>
                    <option value="pos" {{ request('type') == 'pos' ? 'selected' : '' }}>Kasir (POS)</option>
                    <option value="bops" {{ request('type') == 'bops' ? 'selected' : '' }}>Ambil di Toko (BOPS)</option>
                    <option value="delivery" {{ request('type') == 'delivery' ? 'selected' : '' }}>Kirim Alamat</option>
                </select>

                <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Filter</button>
                @if(request()->has('start_date'))
                    <a href="{{ route('admin.sales-report.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Reset</a>
                @endif
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Kanal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-brand-900 text-sm">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-brand-600 hover:underline">{{ $order->invoice_number }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                {{ $order->customer_name ?? ($order->user->name ?? 'Walk-in Customer') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($order->transaction_type == 'pos')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">Kasir</span>
                                @elseif($order->transaction_type == 'bops')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-purple-100 text-purple-800 uppercase tracking-wider">BOPS</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-wider">Kirim</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-brand-600">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data penjualan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-brand-100 bg-white">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const labels = {!! json_encode($chartLabels) !!};
        const data = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet Harian (Rp)',
                    data: data,
                    borderColor: '#1e3a8a', // brand-900
                    backgroundColor: 'rgba(30, 58, 138, 0.1)', // brand-900 with opacity
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#1e3a8a',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Smooth curves
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                if(value >= 1000000) {
                                    return 'Rp' + (value / 1000000) + ' Jt';
                                } else if(value >= 1000) {
                                    return 'Rp' + (value / 1000) + ' Rb';
                                }
                                return 'Rp' + value;
                            }
                        },
                        grid: {
                            color: '#f1f5f9', // slate-100
                            drawBorder: false,
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endsection
