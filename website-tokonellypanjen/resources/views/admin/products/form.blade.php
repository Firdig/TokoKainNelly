@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Produk Kain' : 'Tambah Produk Kain Baru')

@section('content')
<div class="max-w-4xl">
    <div class="mb-8">
        <h2 class="font-outfit text-3xl font-bold text-brand-900">{{ isset($product) ? 'Edit Data Kain' : 'Tambah Produk Kain Baru' }}</h2>
        <p class="mt-1 text-sm text-slate-500">{{ isset($product) ? 'Perbarui informasi deskripsi, harga, tekstur, atau tambah stok kain.' : 'Masukkan detail kain baru yang akan muncul di Katalog dan Kasir.' }}</p>
    </div>

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-brand-100">
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" class="p-8" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
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

            <div class="space-y-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-bold text-brand-900 mb-1">Nama Kain <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Contoh: Kain Katun Jepang Motif Bunga" value="{{ old('name', $product->name ?? '') }}">
                </div>

                <!-- Product Description -->
                <div>
                    <label class="block text-sm font-bold text-brand-900 mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Masukkan detail bahan, motif, warna, dan kecocokan...">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

                <!-- Kategori Produk -->
                <div>
                    <label class="block text-sm font-bold text-brand-900 mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none bg-white">
                        <option value="">Pilih Kategori (Opsional)</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Harga per Meter (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 font-medium">Rp</span>
                            </div>
                            <input type="number" name="price" required class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" min="0" value="{{ old('price', isset($product) ? rtrim(rtrim(number_format($product->price, 2, '.', ''), '0'), '.') : '') }}">
                        </div>
                    </div>
                </div>



                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <!-- Info Teknis Tambahan -->
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Lebar Kain (m)</label>
                        <input type="text" name="width" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Misal: 1.5 meter" value="{{ old('width', $product->width ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Komposisi Bahan</label>
                        <input type="text" name="composition" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Misal: 100% Cotton" value="{{ old('composition', $product->composition ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Petunjuk Perawatan</label>
                        <input type="text" name="fabric_care" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Misal: Cuci dingin, jangan disetrika panas" value="{{ old('fabric_care', $product->fabric_care ?? '') }}">
                    </div>
                </div>

                <!-- Berat Kain (untuk kalkulasi ongkos kirim) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Berat Kain <span class="text-xs text-slate-400 font-normal">(untuk ongkos kirim)</span></label>
                        <input type="number" name="weight_value" min="1" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none" placeholder="Misal: 200" value="{{ old('weight_value', $product->weight_value ?? 200) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-1">Satuan Berat</label>
                        <select name="weight_unit" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow outline-none bg-white">
                            <option value="gsm" {{ old('weight_unit', $product->weight_unit ?? 'gsm') === 'gsm' ? 'selected' : '' }}>GSM (Gram per m²)</option>
                            <option value="gpy" {{ old('weight_unit', $product->weight_unit ?? 'gsm') === 'gpy' ? 'selected' : '' }}>G/Y (Gram per Yard)</option>
                        </select>
                    </div>
                </div>

                <!-- Product Gallery -->
                <div class="mt-8 pt-6 border-t border-brand-100">
                    <label class="block text-sm font-bold text-brand-900 mb-2">Galeri Foto Produk Tambahan (Opsional)</label>
                    <p class="text-xs text-slate-500 mb-3">Pilih banyak foto sekaligus untuk ditampilkan di slideshow halaman detail. Foto varian warna tetap disetel di bawah.</p>
                    <input type="file" name="gallery[]" multiple accept="image/*" class="w-full px-4 py-3 bg-slate-50 rounded-xl border border-slate-300 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    
                    @if(isset($product) && $product->images->count() > 0)
                        <div class="flex gap-4 mt-4 overflow-x-auto pb-2 custom-scrollbar">
                            @foreach($product->images as $img)
                                <div class="relative w-24 h-24 shrink-0 rounded-lg overflow-hidden border border-slate-200">
                                    <img src="{{ route('image.gallery', $img->id) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Variations Section -->
                <div class="mt-8 pt-6 border-t border-brand-100">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-bold text-brand-900">Variasi Warna & Stok <span class="text-red-500">*</span></label>
                        <button type="button" onclick="addVariantRow()" class="px-4 py-1.5 bg-brand-100 text-brand-700 hover:bg-brand-200 font-bold text-xs rounded-lg transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tambah Warna
                        </button>
                    </div>
                    
                    <div id="variants-container" class="space-y-4">
                        @if(isset($product) && $product->variants->count() > 0)
                            @foreach($product->variants as $index => $variant)
                                <div class="variant-row flex gap-4 items-start bg-slate-50 p-4 rounded-xl border border-brand-50 relative">
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    <!-- Photo Preview -->
                                    <div class="w-16 h-16 shrink-0 bg-white rounded-lg border border-slate-200 overflow-hidden flex items-center justify-center relative group">
                                        @if($variant->image_mime)
                                            <img src="{{ route('image.variant', $variant->id) }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs text-slate-400 font-bold">Foto</span>
                                        @endif
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="this.nextElementSibling.click()">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        </div>
                                        <input type="file" name="variants[{{ $index }}][image]" class="hidden" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    
                                    <div class="flex-1 grid grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Nama Warna</label>
                                            <input type="text" name="variants[{{ $index }}][color_name]" value="{{ $variant->color_name }}" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Abu Muda">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Kode Hex</label>
                                            <input type="color" name="variants[{{ $index }}][hex_code]" value="{{ $variant->hex_code ?? '#cccccc' }}" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 mb-1">Stok (m)</label>
                                            <input type="number" step="any" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}" class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none bg-slate-100 text-slate-500 cursor-not-allowed" readonly title="Stok hanya dapat diubah melalui fitur Penerimaan Stok atau Stock Audit">
                                        </div>
                                    </div>

                                    @if($index > 0)
                                    <button type="button" onclick="removeVariantRow(this)" class="text-red-400 hover:text-red-600 p-2 mt-4 ml-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <!-- Default empty row -->
                            <div class="variant-row flex gap-4 items-start bg-slate-50 p-4 rounded-xl border border-brand-50 relative">
                                <div class="w-16 h-16 shrink-0 bg-white rounded-lg border border-slate-200 overflow-hidden flex items-center justify-center relative group">
                                    <span class="text-xs text-slate-400 font-bold">Foto</span>
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="this.nextElementSibling.click()">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    </div>
                                    <input type="file" name="variants[0][image]" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>
                                
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Nama Warna</label>
                                        <input type="text" name="variants[0][color_name]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Misal: Merah Maroon">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Kode Hex</label>
                                        <input type="color" name="variants[0][hex_code]" value="#800000" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-1">Stok (m)</label>
                                        <input type="number" step="any" name="variants[0][stock]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none" min="0">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-brand-100 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-md shadow-brand-600/20 transition-all">
                    {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let variantIndex = {{ isset($product) ? max(1, $product->variants->count()) : 1 }};

    function addVariantRow() {
        const container = document.getElementById('variants-container');
        const html = `
            <div class="variant-row flex gap-4 items-start bg-slate-50 p-4 rounded-xl border border-brand-50 relative mt-4">
                <div class="w-16 h-16 shrink-0 bg-white rounded-lg border border-slate-200 overflow-hidden flex items-center justify-center relative group">
                    <span class="text-xs text-slate-400 font-bold">Foto</span>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="this.nextElementSibling.click()">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                    <input type="file" name="variants[${variantIndex}][image]" class="hidden" accept="image/*" onchange="previewImage(this)">
                </div>
                
                <div class="flex-1 grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Nama Warna</label>
                        <input type="text" name="variants[${variantIndex}][color_name]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none" placeholder="Warna...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Kode Hex</label>
                        <input type="color" name="variants[${variantIndex}][hex_code]" value="#cccccc" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Stok (m)</label>
                        <input type="number" step="any" name="variants[${variantIndex}][stock]" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:ring-1 focus:ring-brand-500 outline-none" min="0" value="0">
                    </div>
                </div>
                
                <button type="button" onclick="removeVariantRow(this)" class="text-red-400 hover:text-red-600 p-2 mt-4 ml-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }

    function removeVariantRow(button) {
        button.closest('.variant-row').remove();
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = input.previousElementSibling.previousElementSibling; // The span or img
                if (container.tagName === 'SPAN') {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    input.parentElement.replaceChild(img, container);
                } else if (container.tagName === 'IMG') {
                    container.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
