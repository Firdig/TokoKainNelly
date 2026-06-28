<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Toko Nelly Panjen</title>
    <meta name="description" content="{{ Str::limit($product->description, 160) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-14 w-auto rounded-xl object-contain">
                    <span class="font-outfit font-bold text-xl text-brand-900 tracking-tight">Toko Kain Nelly</span>
                </a>
                <x-frontend-navbar />
            </div>
        </div>
    </header>

    <main class="flex-1 pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs -->
            <nav class="flex text-sm font-medium mb-8 text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('katalog') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                <span class="mx-2">/</span>
                <span class="text-brand-700 font-semibold truncate max-w-48">{{ $product->name }}</span>
            </nav>

            <!-- Product Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
                <div class="lg:flex">

                    <!-- LEFT: Image Column -->
                    <div class="lg:w-5/12 bg-gradient-to-br from-amber-50 to-brand-50 flex flex-col p-6 lg:p-8 gap-5">
                        <!-- Main Image -->
                        <div class="relative bg-white rounded-2xl shadow-md overflow-hidden aspect-square flex items-center justify-center p-4 border border-brand-100">
                            @php
                                $primaryImage = null;
                                if($product->variants->first() && $product->variants->first()->image_mime) {
                                    $primaryImage = route('image.variant', $product->variants->first()->id);
                                } elseif($product->images->count() > 0 && $product->images->first()->image_mime) {
                                    $primaryImage = route('image.gallery', $product->images->first()->id);
                                }
                            @endphp
                            @if($primaryImage)
                                <div class="absolute inset-0 skeleton-loader rounded-2xl z-0"></div>
                                <img id="main-product-image" src="{{ $primaryImage }}" loading="lazy" onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove();" class="max-w-full max-h-full object-contain drop-shadow-xl transition-all duration-500 opacity-0 relative z-10" alt="{{ $product->name }}">
                            @else
                                <svg id="main-product-image-placeholder" class="w-40 h-40 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            @endif

                            <!-- Out of stock overlay -->
                            <div id="out-of-stock-badge" class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center rounded-2xl {{ $product->variants->first() && $product->variants->first()->stock > 0 ? 'hidden' : '' }}">
                                <span class="bg-red-500 text-white font-bold px-8 py-3 rounded-full text-xl transform -rotate-12 shadow-xl border-4 border-white">STOK HABIS</span>
                            </div>
                        </div>

                        <!-- Gallery Thumbnails -->
                        @if($product->images->count() > 0)
                        <div class="flex gap-3 overflow-x-auto pb-1 custom-scrollbar">
                            @foreach($product->images as $img)
                                <button type="button" onclick="setMainImage('{{ route('image.gallery', $img->id) }}')" 
                                        class="w-16 h-16 shrink-0 bg-white rounded-xl overflow-hidden border-2 border-transparent hover:border-brand-500 focus:border-brand-500 transition-all shadow-sm cursor-pointer relative">
                                    <div class="absolute inset-0 skeleton-loader z-0"></div>
                                    <img src="{{ route('image.gallery', $img->id) }}" loading="lazy" onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove();" class="w-full h-full object-cover relative z-10 opacity-0 transition-opacity duration-500">
                                </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- RIGHT: Details Column -->
                    <div class="lg:w-7/12 p-6 lg:p-10 flex flex-col justify-center">
                        <!-- Tags -->
                        @if($product->category)
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs bg-brand-100 text-brand-700 font-bold px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                        </div>
                        @endif                        
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-brand-900 font-outfit mb-3 leading-tight">{{ $product->name }}</h1>
                        <p class="text-slate-500 leading-relaxed mb-5 text-sm">{{ $product->description }}</p>

                        <!-- Price -->
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-4xl font-extrabold text-brand-600 font-outfit">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-slate-400 font-medium">/ meter</span>
                        </div>

                        <!-- Technical Specs (optional) -->
                        @if($product->category || $product->width || $product->composition || $product->fabric_care)
                        <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100 mb-6">
                            <h3 class="text-xs font-bold text-brand-700 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Informasi Teknis Kain
                            </h3>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-sm">
                                @if($product->category)
                                <div class="flex">
                                    <dt class="text-slate-400 min-w-28">Kategori</dt>
                                    <dd class="font-bold text-brand-900">{{ $product->category->name }}</dd>
                                </div>
                                @endif
                                @if($product->width)
                                <div class="flex">
                                    <dt class="text-slate-400 min-w-28">Lebar Kain</dt>
                                    <dd class="font-bold text-brand-900">{{ $product->width }}</dd>
                                </div>
                                @endif
                                @if($product->composition)
                                <div class="flex">
                                    <dt class="text-slate-400 min-w-28">Komposisi</dt>
                                    <dd class="font-bold text-brand-900">{{ $product->composition }}</dd>
                                </div>
                                @endif
                                @if($product->fabric_care)
                                <div class="flex sm:col-span-2">
                                    <dt class="text-slate-400 min-w-28">Perawatan</dt>
                                    <dd class="font-bold text-brand-900">{{ $product->fabric_care }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                        @endif

                        <!-- Color Variants -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-bold text-brand-900">Pilihan Warna:</span>
                                <span id="selected-color-name" class="text-sm font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-lg">{{ $product->variants->first()->color_name ?? 'Pilih Warna' }}</span>
                            </div>
                            
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->variants as $index => $variant)
                                    <button type="button" 
                                            onclick="selectVariant({{ $variant->id }}, '{{ $variant->color_name }}', {{ $variant->stock }}, '{{ $variant->image_mime ? route('image.variant', $variant->id) : '' }}', this)"
                                            class="variant-btn w-11 h-11 rounded-full border-[3px] {{ $index === 0 ? 'border-brand-600 ring-2 ring-brand-300' : 'border-white hover:border-brand-400' }} transition-all shadow-md relative group"
                                            title="{{ $variant->color_name }} - {{ $variant->stock }}m"
                                            style="background-color: {{ $variant->hex_code }}">
                                        @if($variant->stock <= 0)
                                            <div class="absolute inset-0 flex items-center justify-center rounded-full">
                                                <div class="w-full h-[2px] bg-red-500 transform rotate-45 rounded"></div>
                                            </div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>

                            <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg" id="stock-display">
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                Sisa Stok: {{ $product->variants->first()->stock ?? 0 }} meter
                            </div>
                        </div>

                        <!-- Branch Selector -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-brand-900 mb-2">Pilih Cabang Toko:</label>
                            <div class="relative">
                                <select name="branch" class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl bg-white text-sm font-medium text-brand-900 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="kepanjen" selected>📍 Cabang Kepanjen (Online)</option>
                                    <option value="gondanglegi" disabled class="text-slate-400">📍 Cabang Gondanglegi — Segera Hadir</option>
                                    <option value="turen" disabled class="text-slate-400">📍 Cabang Turen — Segera Hadir</option>
                                    <option value="bululawang" disabled class="text-slate-400">📍 Cabang Bululawang — Segera Hadir</option>
                                </select>
                                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_variant_id" id="variant_id_input" value="{{ $product->variants->first()->id ?? '' }}">
                            
                            @error('quantity')
                                <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">{{ $message }}</div>
                            @enderror

                            <div class="flex items-end gap-4" id="cart-actions-container">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Jumlah (meter)</label>
                                    <div class="flex items-center h-14 bg-white border-2 border-slate-200 rounded-xl overflow-hidden focus-within:border-brand-500 transition-colors w-36">
                                        <button type="button" onclick="const i=this.parentNode.querySelector('input[type=number]'); i.value = (parseFloat(i.value) - 0.5 > 0) ? (parseFloat(i.value) - 0.5) : 0.5" class="w-12 h-full bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold transition-colors border-r border-slate-200 flex items-center justify-center text-lg">−</button>
                                        <input type="number" step="any" name="quantity" id="quantity_input" value="1" min="0.5" max="{{ $product->variants->first()->stock ?? 1 }}" class="w-full h-full text-center text-lg font-bold text-brand-900 border-none focus:ring-0 outline-none">
                                        <button type="button" onclick="const i=this.parentNode.querySelector('input[type=number]'); if(parseFloat(i.value) + 0.5 <= i.max) i.value = parseFloat(i.value) + 0.5;" class="w-12 h-full bg-slate-50 hover:bg-slate-100 text-brand-600 font-bold transition-colors border-l border-slate-200 flex items-center justify-center text-lg">+</button>
                                    </div>
                                </div>
                                
                                <button type="submit" id="add-to-cart-btn" class="flex-1 h-14 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white font-bold font-outfit text-base rounded-xl shadow-lg shadow-brand-600/30 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    Masukkan Keranjang
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-20">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold font-outfit text-brand-900">Kain Lain Yang Mungkin Anda Suka</h2>
                    <a href="{{ route('katalog') }}" class="text-sm text-brand-600 hover:text-brand-700 font-bold flex items-center gap-1">
                        Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('product.show', $related->id) }}" class="group bg-white rounded-2xl border border-brand-100 shadow-sm hover:shadow-xl hover:border-brand-200 transition-all duration-300 overflow-hidden hover:-translate-y-1 flex flex-col">
                        @php
                            $rImg = null;
                            if(isset($related->images) && $related->images->count() > 0 && $related->images->first()->image_mime) $rImg = route('image.gallery', $related->images->first()->id);
                            elseif($related->variants->whereNotNull('image_mime')->count() > 0) $rImg = route('image.variant', $related->variants->whereNotNull('image_mime')->first()->id);
                        @endphp
                        <div class="h-40 bg-gradient-to-br from-amber-50 to-brand-50 relative overflow-hidden">
                            @if($rImg)
                                <div class="absolute inset-0 skeleton-loader z-0"></div>
                                <img src="{{ $rImg }}" loading="lazy" onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove();" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-500 opacity-0 relative z-10" alt="{{ $related->name }}">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-outfit font-bold text-sm text-brand-900 mb-1 line-clamp-1">{{ $related->name }}</h3>
                            <div class="font-outfit font-extrabold text-brand-600 mt-auto">Rp{{ number_format($related->price, 0, ',', '.') }}<span class="text-xs text-slate-400 font-normal">/m</span></div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    <!-- Footer -->
    <x-frontend-footer />

    <!-- Add to Cart Success Modal -->
    <div id="cart-success-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeCartModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full relative animate-fade-in">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="font-outfit font-bold text-xl text-brand-900 mb-2">Berhasil Ditambahkan!</h3>
                    <p class="text-slate-500 text-sm mb-8">Produk berhasil dimasukkan ke keranjang belanja Anda.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="closeCartModal()" class="flex-1 px-6 py-3.5 border-2 border-brand-200 text-brand-700 rounded-xl font-bold text-sm hover:bg-brand-50 transition-colors">
                            Lanjut Belanja
                        </button>
                        <a href="{{ route('cart.index') }}" class="flex-1 px-6 py-3.5 bg-gradient-to-r from-brand-600 to-brand-700 text-white rounded-xl font-bold text-sm hover:from-brand-700 hover:to-brand-800 transition-all text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Pergi ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setMainImage(url) {
            const imgEl = document.getElementById('main-product-image');
            if(imgEl) {
                imgEl.style.opacity = '0';
                setTimeout(() => { imgEl.src = url; imgEl.style.opacity = '1'; }, 150);
            }
        }

        function selectVariant(id, colorName, stock, imagePath, btnElement) {
            document.querySelectorAll('.variant-btn').forEach(btn => {
                btn.classList.remove('border-brand-600', 'ring-2', 'ring-brand-300');
                btn.classList.add('border-white');
            });
            btnElement.classList.add('border-brand-600', 'ring-2', 'ring-brand-300');
            btnElement.classList.remove('border-white');

            document.getElementById('selected-color-name').innerText = colorName;
            
            const stockDot = stock > 0 ? 'bg-green-400' : 'bg-red-400';
            document.getElementById('stock-display').innerHTML = `<span class="w-2 h-2 ${stockDot} rounded-full"></span> Sisa Stok: ${stock} meter`;

            if (imagePath && imagePath.trim() !== '') {
                setMainImage(imagePath);
            }

            document.getElementById('variant_id_input').value = id;
            document.getElementById('quantity_input').max = stock;

            const actionContainer = document.getElementById('cart-actions-container');
            const cartBtn = document.getElementById('add-to-cart-btn');
            const outOfStockBadge = document.getElementById('out-of-stock-badge');

            if (stock <= 0) {
                actionContainer.classList.add('opacity-50', 'pointer-events-none');
                cartBtn.innerText = 'Stok Habis';
                cartBtn.disabled = true;
                outOfStockBadge.classList.remove('hidden');
            } else {
                actionContainer.classList.remove('opacity-50', 'pointer-events-none');
                cartBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg> Masukkan Keranjang`;
                cartBtn.disabled = false;
                outOfStockBadge.classList.add('hidden');
                if(parseFloat(document.getElementById('quantity_input').value) > stock) {
                    document.getElementById('quantity_input').value = stock;
                }
            }
        }

        // Cart modal functions
        function openCartModal() {
            document.getElementById('cart-success-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeCartModal() {
            document.getElementById('cart-success-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Intercept form submit to show modal instead of redirect
        document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const btn = document.getElementById('add-to-cart-btn');
            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menambahkan...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.status === 401) {
                    return response.json().then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                }
                if(response.redirected || response.ok) {
                    openCartModal();
                } else {
                    return response.text().then(text => { throw new Error(text); });
                }
            }).catch(err => {
                if (err.message) {
                    alert('Gagal menambahkan ke keranjang. Silakan coba lagi.');
                }

            }).finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            });
        });

        window.addEventListener('DOMContentLoaded', () => {
            let firstStock = {{ $product->variants->first()->stock ?? 1 }};
            if(firstStock <= 0) {
                const actionContainer = document.getElementById('cart-actions-container');
                const cartBtn = document.getElementById('add-to-cart-btn');
                actionContainer.classList.add('opacity-50', 'pointer-events-none');
                cartBtn.innerText = 'Stok Habis';
                cartBtn.disabled = true;
            }
        });
    </script>

</body>
</html>
