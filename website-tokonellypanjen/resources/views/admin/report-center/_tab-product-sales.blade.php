{{-- ═══════════════════════════════════════════════════════════════
     TAB: PENJUALAN PER PRODUK
     Konten dari admin/product-sales-report/index.blade.php
═══════════════════════════════════════════════════════════════ --}}

<div class="space-y-8">

    {{-- Filters --}}
    <form action="{{ route('admin.report-center.index') }}" method="GET" class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100">
        <input type="hidden" name="tab" value="product-sales">
        <div class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Cari Produk</label>
                <input type="text" name="ps_search" value="{{ $psSearch }}" placeholder="Nama produk..."
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none w-56">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Dari Tanggal</label>
                <input type="date" name="ps_date_from" value="{{ $psDateFrom }}"
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Sampai Tanggal</label>
                <input type="date" name="ps_date_to" value="{{ $psDateTo }}"
                    class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 transition-colors">
                Filter
            </button>
            @if($psSearch || $psDateFrom || $psDateTo)
            <a href="{{ route('admin.report-center.index', ['tab' => 'product-sales']) }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- Chart: Top 10 Products --}}
    @if(count($psChartLabels) > 0)
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4">10 Produk Terlaris (Volume Penjualan)</h3>
        <div style="height: 300px;">
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>
    @endif

    {{-- Products Table --}}
    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Detail Penjualan Per Produk</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Stok Sisa</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Terjual (m)</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-brand-900 uppercase">Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($psProducts as $product)
                    <tr class="hover:bg-brand-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-brand-900">{{ $product->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $product->variants->count() }} varian warna
                            </div>
                        </td>
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">Tidak ada data produk ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($psProducts->hasPages())
        <div class="px-6 py-4 border-t border-brand-100">
            {{ $psProducts->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
