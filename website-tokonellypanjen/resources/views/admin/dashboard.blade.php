@extends('layouts.admin')

@section('title', 'Overview Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Asset Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-500 mb-1">Total Aset Kain (Nilai Jual)</div>
            <div class="text-2xl font-extrabold text-brand-900 font-outfit">Rp{{ number_format($totalAssets, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-500 mb-1">Total Entitas Kain</div>
            <div class="text-2xl font-extrabold text-brand-900 font-outfit">{{ number_format($totalProducts) }}</div>
        </div>
    </div>

    <!-- Active Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-500 mb-1">Pesanan Online (Pending)</div>
            <div class="text-2xl font-extrabold text-brand-900 font-outfit">{{ $pendingOrders }}</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-brand-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-outfit font-bold text-xl text-brand-900">Grafik Penjualan E-Commerce (Bulan Ini)</h3>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity / Low Stock -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100">
        <h3 class="font-outfit font-bold text-xl text-brand-900 mb-6">Peringatan Stok Terbatas</h3>
        <div class="space-y-4 max-h-72 overflow-y-auto pr-2 custom-scrollbar">
            @forelse($lowStockProducts as $variant)
            <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl border border-red-100">
                <div>
                    <div class="font-bold text-red-900 line-clamp-1 max-w-[150px]">{{ $variant->product->name }} ({{ $variant->color_name }})</div>
                    <div class="text-xs text-red-700 mt-1">Sisa: {{ $variant->stock }} meter</div>
                </div>
                <!-- Adjust to route name for products edit -->
                <a href="{{ url('admin/products/' . $variant->product_id . '/edit') }}" class="px-3 py-1.5 bg-white text-red-600 rounded-lg shadow-sm text-xs font-bold hover:bg-red-600 hover:text-white transition-colors">Tambah</a>
            </div>
            @empty
            <div class="text-center py-8 text-slate-500 text-sm">Semua stok kain dalam batas aman.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json(array_values($monthlySales));
        const labels = @json(array_keys($monthlySales));

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pemasukan (Rp)',
                    data: salesData,
                    borderColor: '#2563eb', // brand-500
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
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
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Outfit', size: 14 },
                        bodyFont: { family: 'Inter', size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': Rp';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: 'Inter' }, color: '#64748b' }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: 'Inter' },
                            color: '#64748b',
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + 'jt';
                                if (value >= 1000) return (value / 1000) + 'k';
                                return value;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
