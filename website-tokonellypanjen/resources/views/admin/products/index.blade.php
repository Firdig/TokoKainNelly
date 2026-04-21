@extends('layouts.admin')

@section('title', 'Manajemen Produk Kain')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Daftar Produk Kain</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola master data produk, harga, dan stok kain.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-900 focus:outline-none transition-all hover:-translate-y-0.5 shadow-brand-500/30">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Produk Baru
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start shadow-sm">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-16">No</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit">Nama & Spesifikasi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-40">Harga / Meter</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-32">Stok (m)</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-brand-50 font-inter">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-brand-50/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-brand-900">{{ $product->name }}</div>
                            <div class="text-xs text-brand-600 mt-1 uppercase font-bold tracking-wider">{{ $product->texture ?? 'Tekstur Standar' }} • {{ $product->comfort_level ? $product->comfort_level.' Bintang' : 'Kenyamanan Standar' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-brand-600">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->stock > 10)
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 w-fit">
                                        Total: {{ $product->stock }} m
                                    </span>
                                    <div class="text-[10px] text-slate-400 font-medium">{{ $product->variants->count() }} Warna</div>
                                </div>
                            @elseif($product->stock > 0)
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-800 w-fit">
                                        Total sisa: {{ $product->stock }} m
                                    </span>
                                    <div class="text-[10px] text-slate-400 font-medium">{{ $product->variants->count() }} Warna</div>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    Semua warna habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-brand-600 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 p-2 rounded-lg transition-colors" title="Edit Data & Stok">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Hapus Produk">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <h3 class="mt-2 text-sm font-medium text-brand-900">Belum ada data kain</h3>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
