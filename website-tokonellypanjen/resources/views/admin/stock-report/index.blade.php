@extends('layouts.admin')

@section('title', 'Laporan Stok')

@section('content')
<div class="space-y-6">

    {{-- ══════════════════════════════════════════════════════════
         Header
    ══════════════════════════════════════════════════════════ --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-brand-900">Laporan Pergerakan Stok</h2>
            <p class="text-sm text-slate-500 mt-1">Kronologi lengkap pergerakan stok — kapan, berapa, karena transaksi apa.</p>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         Summary Cards
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total Keluar --}}
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok Keluar</p>
                <p class="text-2xl font-bold text-red-600 font-outfit">
                    {{ number_format($totalKeluar, 2, ',', '.') }}
                    <span class="text-sm font-normal text-slate-400">meter</span>
                </p>
            </div>
        </div>

        {{-- Total Masuk --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok Masuk</p>
                <p class="text-2xl font-bold text-emerald-600 font-outfit">
                    {{ number_format($totalMasuk, 2, ',', '.') }}
                    <span class="text-sm font-normal text-slate-400">meter</span>
                </p>
            </div>
        </div>

        {{-- Total Movement --}}
        <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pergerakan</p>
                <p class="text-2xl font-bold text-brand-700 font-outfit">
                    {{ number_format($totalCount, 0, ',', '.') }}
                    <span class="text-sm font-normal text-slate-400">record</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         Filter Bar
    ══════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6">
        <form method="GET" action="{{ route('admin.stock-report.index') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

            {{-- Dropdown Varian Produk --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">
                    Produk / Varian
                </label>
                <select name="product_variant_id" id="filter_variant"
                        class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2.5 text-sm text-brand-900
                               focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                    <option value="">— Semua Varian —</option>
                    @foreach ($variants as $v)
                        <option value="{{ $v->id }}"
                                {{ $variantId == $v->id ? 'selected' : '' }}>
                            {{ $v->product->name }} — {{ $v->color_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">
                    Dari Tanggal
                </label>
                <input type="date" name="date_from" id="filter_date_from"
                       value="{{ $dateFrom }}"
                       class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2.5 text-sm text-brand-900
                              focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">
                    Sampai Tanggal
                </label>
                <input type="date" name="date_to" id="filter_date_to"
                       value="{{ $dateTo }}"
                       class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2.5 text-sm text-brand-900
                              focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
            </div>

            {{-- Tipe Movement --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">
                    Tipe Pergerakan
                </label>
                <select name="movement_type" id="filter_type"
                        class="w-full rounded-xl border border-brand-200 bg-white px-3 py-2.5 text-sm text-brand-900
                               focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent">
                    <option value="">— Semua Tipe —</option>
                    @foreach ($movementTypes as $key => $label)
                        <option value="{{ $key }}" {{ $movementType === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol --}}
            <div class="sm:col-span-2 lg:col-span-4 flex gap-3 justify-end">
                <a href="{{ route('admin.stock-report.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600 hover:bg-slate-50 transition-colors font-medium">
                    Reset Filter
                </a>
                <button type="submit" id="btn_filter_stok"
                        class="px-6 py-2.5 rounded-xl bg-brand-600 text-white text-sm font-semibold
                               hover:bg-brand-700 active:scale-95 transition-all shadow-sm">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         Tabel Pergerakan Stok
    ══════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">

        {{-- Header tabel --}}
        <div class="px-6 py-4 border-b border-brand-50 flex items-center justify-between">
            <h3 class="font-semibold font-outfit text-brand-900 text-base">
                Kronologi Pergerakan Stok
            </h3>
            <span class="text-xs text-slate-400">
                Menampilkan {{ $movements->firstItem() ?? 0 }}–{{ $movements->lastItem() ?? 0 }}
                dari {{ $movements->total() }} record
            </span>
        </div>

        @if ($movements->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <svg class="w-16 h-16 text-brand-100 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-base font-semibold text-slate-400">Belum ada data pergerakan stok.</p>
                <p class="text-sm text-slate-300 mt-1">Data akan muncul setelah ada transaksi yang diproses.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-brand-50/60 text-left">
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider whitespace-nowrap">Waktu</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">Produk / Varian</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider whitespace-nowrap">Tipe</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right whitespace-nowrap">Jumlah (m)</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right whitespace-nowrap">Stok Sebelum</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider text-right whitespace-nowrap">Stok Sesudah</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">Referensi</th>
                            <th class="px-5 py-3.5 font-semibold text-xs text-slate-500 uppercase tracking-wider">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($movements as $m)
                            <tr class="hover:bg-brand-50/30 transition-colors">

                                {{-- Waktu --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="text-xs font-semibold text-brand-900">
                                        {{ $m->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        {{ $m->created_at->format('H:i:s') }}
                                    </div>
                                </td>

                                {{-- Produk / Varian --}}
                                <td class="px-5 py-4">
                                    @if ($m->productVariant)
                                        <div class="font-medium text-brand-900 leading-tight">
                                            {{ $m->productVariant->product->name ?? '—' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if ($m->productVariant->hex_code)
                                                <span class="inline-block w-3 h-3 rounded-full border border-slate-200 flex-shrink-0"
                                                      style="background-color: {{ $m->productVariant->hex_code }}"></span>
                                            @endif
                                            <span class="text-xs text-slate-400">{{ $m->productVariant->color_name }}</span>
                                        </div>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>

                                {{-- Tipe Badge --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $m->getTypeBadgeColor() }}">
                                        {{ $m->getTypeLabel() }}
                                    </span>
                                </td>

                                {{-- Jumlah --}}
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    @if ($m->quantity < 0)
                                        <span class="font-bold text-red-600 tabular-nums">
                                            {{ number_format($m->quantity, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="font-bold text-emerald-600 tabular-nums">
                                            +{{ number_format($m->quantity, 2, ',', '.') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Stok Sebelum --}}
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <span class="text-slate-500 tabular-nums">
                                        {{ number_format($m->stock_before, 2, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Stok Sesudah --}}
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <span class="font-semibold text-brand-900 tabular-nums">
                                        {{ number_format($m->stock_after, 2, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Referensi --}}
                                <td class="px-5 py-4">
                                    @if ($m->reference_type === 'order' && $m->reference_id)
                                        @php
                                            $refOrder = \App\Models\Order::select('id','invoice_number')->find($m->reference_id);
                                        @endphp
                                        @if ($refOrder)
                                            <a href="{{ route('admin.orders.index') }}?search={{ $refOrder->invoice_number }}"
                                               class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 hover:text-brand-800
                                                      hover:underline transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                                {{ $refOrder->invoice_number }}
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-300">Order #{{ $m->reference_id }}</span>
                                        @endif
                                    @elseif ($m->reference_type === 'stock_audit' && $m->reference_id)
                                        <span class="text-xs text-slate-400">Audit #{{ $m->reference_id }}</span>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>

                                {{-- Oleh --}}
                                <td class="px-5 py-4">
                                    @if ($m->createdBy)
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center
                                                        font-bold text-xs flex-shrink-0">
                                                {{ substr($m->createdBy->name, 0, 1) }}
                                            </div>
                                            <span class="text-xs text-brand-900 font-medium leading-tight">
                                                {{ $m->createdBy->name }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-300">Sistem</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($movements->hasPages())
                <div class="px-6 py-4 border-t border-brand-50">
                    {{ $movements->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
