@extends('layouts.admin')

@section('title', 'Stock Opname (Audit Inventaris)')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <div>
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Stock Opname</h2>
        <p class="mt-1 text-sm text-slate-500">Bandingkan Stok Sistem dengan Stok Fisik Toko secara massal.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('info'))
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-blue-700 font-bold">{{ session('info') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- OPNAME FORM AREA -->
        <div class="xl:col-span-2">
            <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-brand-100 bg-brand-50 flex justify-between items-center">
                    <h3 class="font-outfit font-bold text-lg text-brand-900">Entri Stock Opname</h3>
                    <span class="text-xs font-bold bg-amber-100 text-amber-800 px-3 py-1 rounded-full">Proses Cepat</span>
                </div>
                
                <form action="{{ route('stock-opname.store') }}" method="POST" class="p-0">
                    @csrf
                    <div class="overflow-x-auto max-h-[600px] custom-scrollbar">
                        <table class="min-w-full divide-y divide-brand-100">
                            <thead class="bg-white sticky top-0 shadow-sm z-10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase">Nama Produk</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-brand-900 uppercase w-32">Stok Sistem</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-brand-900 uppercase w-40">Stok Fisik (Input)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase">Catatan Audit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-50">
                                @foreach($products as $index => $product)
                                <tr class="hover:bg-brand-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-brand-900">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-500 mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}/m</div>
                                        <input type="hidden" name="audits[{{ $index }}][product_id]" value="{{ $product->id }}">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-bold {{ $product->stock > 0 ? 'text-brand-600' : 'text-red-600' }}">
                                            {{ $product->stock }} m
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="number" step="0.5" name="audits[{{ $index }}][physical_stock]" class="w-full text-center px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" placeholder="Mtr Fisik">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="audits[{{ $index }}][notes]" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" placeholder="Cth: Hilang sobek, dsb">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 bg-brand-50 border-t border-brand-100 text-right sticky bottom-0 z-20">
                        <button type="submit" class="px-8 py-3 bg-brand-900 hover:bg-brand-950 text-white rounded-xl font-bold shadow-lg shadow-brand-900/20 transition-all">
                            Simpan Hasil Opname Fisik
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- RECENT AUDITS -->
        <div>
            <div class="bg-white shadow-sm border border-brand-100 rounded-2xl p-6">
                <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Audit Terakhir
                </h3>
                
                <div class="space-y-4">
                    @forelse($recentAudits as $audit)
                    <div class="p-4 rounded-xl border border-brand-100 bg-brand-50/50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-brand-500">{{ $audit->created_at->diffForHumans() }}</span>
                            @if($audit->difference < 0)
                                <span class="text-xs font-bold bg-red-100 text-red-800 px-2 py-0.5 rounded-md">Minus {{ abs($audit->difference) }}m</span>
                            @elseif($audit->difference > 0)
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2 py-0.5 rounded-md">Plus {{ $audit->difference }}m</span>
                            @else
                                <span class="text-xs font-bold bg-slate-200 text-slate-800 px-2 py-0.5 rounded-md">Aman</span>
                            @endif
                        </div>
                        <div class="text-sm font-bold text-brand-900">{{ $audit->product->name }}</div>
                        <div class="text-xs text-slate-500 mt-1 flex justify-between">
                            <span>Oleh: {{ $audit->auditor->name }}</span>
                            <span class="font-medium">Sys: {{ $audit->system_stock }} &rarr; Fisik: {{ $audit->physical_stock }}</span>
                        </div>
                        @if($audit->notes)
                        <div class="mt-2 text-xs bg-white border border-brand-100 p-2 rounded text-slate-600 block italic">
                            "{{ $audit->notes }}"
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="py-10 text-center text-slate-500 text-sm">Belum ada riwayat stock opname yang tercatat sejauh ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
