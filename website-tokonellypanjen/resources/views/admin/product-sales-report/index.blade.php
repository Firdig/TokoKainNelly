@extends('layouts.admin')

@section('title', 'Laporan Penjualan Per Produk')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div>
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Penjualan Per Produk</h2>
        <p class="mt-1 text-sm text-slate-500">Analisis histori penjualan untuk setiap produk kain guna mendukung keputusan restocking.</p>
    </div>

    <!-- Filters -->
    <form action="{{ route('admin.product-sales-report.index') }}" method="GET" class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100">
        <div class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Cari Produk</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama produk..."
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none w-56">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}"
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}"
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 transition-colors">
                Filter
            </button>
            @if($search || $dateFrom || $dateTo)
            <a href="{{ route('admin.product-sales-report.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>

    <!-- Chart: Top 10 Products -->
    @if(count($chartLabels) > 0)
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4">10 Produk Terlaris (Volume Penjualan)</h3>
        <div style="height: 300px;">
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Detail Penjualan Per Produk</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Jenis Kain</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Stok Sisa</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Terjual (m)</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-brand-900 uppercase">Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-brand-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-brand-900">{{ $product->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $product->variants->count() }} varian warna
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $product->fabric_type ?? '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            @php $totalStock = $product->variants->sum('stock'); @endphp
                            <span class="text-sm font-bold {{ $totalStock <= 10 ? 'text-red-600' : 'text-brand-900' }}">
                                {{ number_format($totalStock, 1) }}m
                            </span>
                            @if($totalStock <= 10)
                                <span class="ml-1 text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">LOW</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-brand-900">
                            {{ number_format($product->total_sold, 1) }}m
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-700">
                                {{ $product->order_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-brand-900">
                            Rp{{ number_format($product->total_revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada data produk ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-brand-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@if(count($chartLabels) > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Terjual (meter)',
                data: @json($chartData),
                backgroundColor: 'rgba(154, 121, 37, 0.2)',
                borderColor: 'rgba(154, 121, 37, 1)',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => v + 'm' }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        font: { size: 11 }
                    }
                }
            }
        }
    });
});
</script>
@endif
@endsection
