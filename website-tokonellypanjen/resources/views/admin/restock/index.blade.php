@extends('layouts.admin')

@section('title', 'Penerimaan Stok (Restock)')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h2 class="font-outfit text-3xl font-bold text-brand-900">Penerimaan Stok</h2>
        <p class="mt-1 text-sm text-slate-500">Tambahkan kuantitas stok baru dengan aman. Data akan otomatis masuk ke Laporan Stok.</p>
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

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex">
            <div class="ml-3">
                <h3 class="text-sm font-bold text-red-800">Mohon periksa form Anda:</h3>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-brand-500"></div>
        
        <form action="{{ route('admin.restock.store') }}" method="POST">
            @csrf

            <!-- Product Selection -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-brand-900 mb-2">Pilih Varian Kain <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="product_variant_id" id="product_variant_id" required class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none bg-white appearance-none text-sm font-medium text-slate-700">
                        <option value="">-- Ketik atau Pilih Varian Kain --</option>
                        @foreach($products as $product)
                            <optgroup label="{{ $product->name }}">
                                @foreach($product->variants as $variant)
                                    <option value="{{ $variant->id }}" data-current-stock="{{ $variant->stock }}">
                                        {{ $product->name }} - {{ $variant->color_name }} (Stok saat ini: {{ $variant->stock }} m)
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Current Stock Info -->
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Stok Saat Ini</p>
                    <div class="flex items-end gap-1">
                        <span id="display_current_stock" class="text-3xl font-black text-slate-700">0</span>
                        <span class="text-sm font-medium text-slate-500 mb-1">meter</span>
                    </div>
                </div>

                <!-- Quantity to Add -->
                <div>
                    <label class="block text-sm font-bold text-brand-900 mb-2">Jumlah Ditambahkan (m) <span class="text-red-500">*</span></label>
                    <input type="number" step="any" name="quantity" required min="0.1" placeholder="Contoh: 50" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none text-lg font-bold text-brand-700 bg-green-50/30">
                    <p class="text-xs text-slate-500 mt-2">Jumlah ini akan **ditambahkan** ke stok saat ini.</p>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-8">
                <label class="block text-sm font-bold text-brand-900 mb-2">Catatan / Referensi</label>
                <input type="text" name="notes" placeholder="Contoh: PO-123 dari Supplier A" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none text-sm">
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-md shadow-brand-600/20 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('product_variant_id');
        const displayStock = document.getElementById('display_current_stock');

        selectElement.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                displayStock.textContent = selectedOption.getAttribute('data-current-stock');
            } else {
                displayStock.textContent = '0';
            }
        });
    });
</script>
@endsection
