@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Manajemen Kategori</h2>
            <p class="mt-1 text-sm text-slate-500">Kelola kategori produk kain.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800 font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-800 font-medium">{{ session('error') }}</div>
    @endif

    <!-- Form Tambah Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4">Tambah Kategori Baru</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori..." required
                   class="flex-1 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 text-sm py-2.5 px-4"
                   value="{{ old('name') }}">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all">
                Tambah
            </button>
        </form>
        @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Daftar Kategori -->
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-brand-100 bg-brand-50/50">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Daftar Kategori</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Kategori</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Jumlah Produk</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-brand-50 transition-colors" x-data="{ editing: false }">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span x-show="!editing" class="font-bold text-brand-900 text-sm">{{ $category->name }}</span>
                                <form x-show="editing" action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex gap-2" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}" required
                                           class="rounded-lg border border-slate-200 text-sm py-1.5 px-3 focus:ring-2 focus:ring-brand-400">
                                    <button type="submit" class="bg-brand-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold">Simpan</button>
                                    <button type="button" @click="editing = false" class="bg-slate-200 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-bold">Batal</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-brand-100 text-brand-800">{{ $category->products_count }} produk</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button x-show="!editing" @click="editing = true" class="text-brand-600 hover:text-brand-800 text-xs font-bold px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 transition-colors">Edit</button>
                                    @if($category->products_count === 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 transition-colors">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
