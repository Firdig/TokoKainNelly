@extends('layouts.admin')

@section('title', 'Overview Dashboard')

@section('content')

{{-- Notification Banner: Pending Online Orders --}}
@if($pendingOrders > 0)
<div class="mb-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-5 shadow-sm">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <div>
                <h3 class="font-outfit font-bold text-amber-900 text-lg">{{ $pendingOrders }} Pesanan Online Menunggu!</h3>
                <p class="text-sm text-amber-700 mt-0.5">
                    @if($pendingBops > 0)<span class="font-semibold">{{ $pendingBops }} BOPS (Pickup)</span>@endif
                    @if($pendingBops > 0 && $pendingDelivery > 0) &bull; @endif
                    @if($pendingDelivery > 0)<span class="font-semibold">{{ $pendingDelivery }} Delivery</span>@endif
                    — Segera proses untuk kepuasan pelanggan.
                </p>
            </div>
        </div>
        <a href="{{ url('/admin/orders?status=pending') }}" class="px-5 py-2.5 bg-brand-900 hover:bg-brand-800 text-white rounded-xl font-bold text-sm shadow-md transition-all hover:-translate-y-0.5 flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Lihat Pesanan
        </a>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    @if(Auth::user()->role === 'admin')
    <!-- Total Asset Card (Superadmin Only) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-500 mb-1">Total Aset Kain (Nilai Jual)</div>
            <div class="text-2xl font-extrabold text-brand-900 font-outfit">Rp{{ number_format($totalAssets, 0, ',', '.') }}</div>
        </div>
    </div>
    @endif

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
    @if(Auth::user()->role === 'admin')
    <!-- Chart (Superadmin Only) -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-brand-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-outfit font-bold text-xl text-brand-900">Grafik Penjualan E-Commerce (Bulan Ini)</h3>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    @endif

    <!-- Recent Activity / Low Stock -->
    <div class="{{ Auth::user()->role === 'admin' ? '' : 'lg:col-span-3' }} bg-white rounded-3xl p-8 shadow-sm border border-brand-100">
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

@if(Auth::user()->role === 'admin')
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
@endif
@endsection
