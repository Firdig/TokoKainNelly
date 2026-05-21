{{-- ═══════════════════════════════════════════════════════════════
     TAB: NILAI ASET INVENTARIS
     Konten dari admin/asset-report/index.blade.php
═══════════════════════════════════════════════════════════════ --}}

<div class="space-y-8">

    {{-- Total Asset Card --}}
    <div class="bg-gradient-to-br from-brand-800 to-brand-900 rounded-3xl p-8 text-white relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full"></div>
        <div class="absolute -left-6 -bottom-6 w-28 h-28 bg-white/5 rounded-full"></div>
        <p class="text-brand-300 text-sm font-bold uppercase tracking-wider mb-2">Total Nilai Aset Inventaris</p>
        <p class="font-outfit font-black text-4xl sm:text-5xl relative z-10">Rp{{ number_format($assetTotal, 0, ',', '.') }}</p>
        <p class="text-brand-300 text-sm mt-2">{{ $assetProducts->count() }} produk &middot; {{ $assetProducts->sum('total_stock') }} meter total stok</p>
    </div>

    {{-- Ringkasan Per Kategori --}}
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Rincian Per Kategori</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Jumlah Produk</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total Stok (m)</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Nilai Aset</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach($assetCategories as $cat)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-brand-900 text-sm">{{ $cat['name'] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ $cat['product_count'] }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600">{{ number_format($cat['total_stock'], 1, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-brand-600">Rp{{ number_format($cat['asset_value'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-500">
                                {{ $assetTotal > 0 ? number_format(($cat['asset_value'] / $assetTotal) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-brand-50">
                    <tr>
                        <td class="px-6 py-4 font-bold text-brand-900 text-sm">Total</td>
                        <td class="px-6 py-4 text-center font-bold text-brand-900 text-sm">{{ $assetProducts->count() }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">{{ number_format($assetProducts->sum('total_stock'), 1, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">Rp{{ number_format($assetTotal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Rincian Per Produk --}}
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50 flex justify-between items-center">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Rincian Per Produk</h3>
            <button onclick="window.print()" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Harga/m</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total Stok (m)</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Nilai Aset</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @foreach($assetProducts as $index => $product)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold text-brand-900 text-sm">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                @if($product->category)
                                    <span class="px-2 py-0.5 bg-brand-50 text-brand-600 rounded-full text-xs font-bold">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600">{{ number_format($product->total_stock, 1, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-brand-600">Rp{{ number_format($product->asset_value, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
