<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kain - Toko Nelly Panjen</title>
    <meta name="description" content="Katalog kain lengkap di Toko Nelly Panjen — batik, katun, satin, dan banyak motif tersedia.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100 transition-all">
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

    <!-- Page Title Hero Bar -->
    <div class="bg-gradient-to-br from-brand-800 to-brand-600 pt-28 pb-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full border-[40px] border-white -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-56 h-56 rounded-full border-[30px] border-white translate-y-1/2 -translate-x-1/4"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex text-sm font-medium mb-4">
                <a href="{{ route('home') }}" class="text-brand-300 hover:text-white transition-colors">Beranda</a>
                <span class="text-brand-500 mx-2">/</span>
                <span class="text-white">Katalog</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white font-outfit">Katalog Kain Kami</h1>
            <p class="text-brand-200 mt-2 text-sm md:text-base max-w-xl">Temukan kain impian Anda dari ratusan koleksi pilihan — batik, katun, satin, dan banyak lagi.</p>
        </div>
    </div>

    <main class="flex-1 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="md:flex gap-8">
                <!-- Sidebar Filter -->
                <aside class="w-full md:w-64 shrink-0 mb-8 md:mb-0">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 sticky top-28">
                        <h3 class="font-outfit font-bold text-base text-brand-900 mb-5 flex items-center gap-2">
                            <div class="w-7 h-7 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </div>
                            Filter Produk
                        </h3>
                        
                        <form action="{{ route('katalog') }}" method="GET" class="space-y-5">
                            <!-- Search -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Pencarian</label>
                                <div class="relative">
                                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kain..."
                                        class="w-full rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 outline-none transition-all bg-white text-slate-700 text-sm py-2.5 pr-4"
                                        style="padding-left: 2.25rem;">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </span>
                                </div>
                            </div>

                            <!-- Sort -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Urutkan</label>
                                <select name="sort" class="input-field text-sm py-2.5 bg-white" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Paling Baru</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                                </select>
                            </div>

                            <!-- Fabric Type Filter -->
                            @if(isset($fabricTypes) && $fabricTypes->count() > 0)
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Jenis Kain</label>
                                <select name="fabric_type" class="input-field text-sm py-2.5 bg-white" onchange="this.form.submit()">
                                    <option value="">Semua Jenis</option>
                                    @foreach($fabricTypes as $type)
                                        <option value="{{ $type }}" {{ request('fabric_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-brand-600/20">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <span>Cari</span>
                            </button>

                            @if(request()->has('q') || request()->has('sort') || request()->has('fabric_type'))
                                <a href="{{ route('katalog') }}" class="flex items-center justify-center gap-1.5 w-full text-center py-2 text-sm text-slate-500 hover:text-brand-600 font-medium transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="flex-1 min-w-0">
                    <div class="mb-6 flex flex-wrap gap-3 justify-between items-center">
                        <div>
                            <h2 class="text-xl font-outfit font-bold text-brand-900">Semua Koleksi Kain</h2>
                            <p class="text-sm text-slate-400 mt-0.5">{{ $products->total() }} produk ditemukan</p>
                        </div>
                        @if(request('q'))
                            <div class="flex items-center gap-2 bg-brand-100 text-brand-700 px-3 py-1.5 rounded-full text-sm font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                "{{ request('q') }}"
                            </div>
                        @endif
                    </div>

                    @if($products->isEmpty())
                        <div class="bg-white rounded-2xl p-16 text-center border border-brand-100 shadow-sm">
                            <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-brand-900 mb-2 font-outfit">Produk Tidak Ditemukan</h3>
                            <p class="text-slate-400 text-sm">Coba kata kunci lain atau reset filter.</p>
                            <a href="{{ route('katalog') }}" class="mt-4 inline-block btn-outline text-sm px-5 py-2">Reset</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach($products as $product)
                            <article class="group bg-white rounded-2xl border border-brand-100 shadow-sm hover:shadow-xl hover:shadow-brand-600/8 hover:border-brand-200 transition-all duration-300 flex flex-col overflow-hidden relative hover:-translate-y-1">
                                
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-white/70 backdrop-blur-[1px] z-20 flex flex-col items-center justify-center rounded-2xl">
                                        <span class="bg-red-500 text-white font-bold px-5 py-2 rounded-full text-sm transform -rotate-6 shadow-lg">Stok Habis</span>
                                    </div>
                                @endif

                                <!-- Image Area -->
                                <div class="h-56 bg-gradient-to-br from-amber-50 to-brand-50 relative overflow-hidden">
                                    @php
                                        $primaryImage = null;
                                        if($product->images->count() > 0 && $product->images->first()->image_mime) { $primaryImage = route('image.gallery', $product->images->first()->id); }
                                        elseif($product->variants->whereNotNull('image_mime')->count() > 0) { $primaryImage = route('image.variant', $product->variants->whereNotNull('image_mime')->first()->id); }
                                    @endphp
                                    
                                    @if($primaryImage)
                                        <div class="absolute inset-0 skeleton-loader z-0"></div>
                                        <img src="{{ $primaryImage }}" alt="{{ $product->name }}" loading="lazy" onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove();" class="w-full h-full object-cover transition-all duration-700 opacity-0 group-hover:scale-110 relative z-10">
                                    @else
                                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                            <svg class="w-14 h-14 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs text-brand-300 font-medium">Belum ada foto</span>
                                        </div>
                                    @endif

                                    <!-- Color Bubble Overlay -->
                                    @if($product->variants->count() > 0)
                                        <div class="absolute bottom-2.5 right-3 flex -space-x-1.5 items-center z-10 group-hover:-translate-y-1 transition-transform duration-300">
                                            @foreach($product->variants->take(5) as $variant)
                                                <div class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background-color: {{ $variant->hex_code ?? '#ccc' }}" title="{{ $variant->color_name }}"></div>
                                            @endforeach
                                            @if($product->variants->count() > 5)
                                                <div class="w-5 h-5 rounded-full bg-white border-2 border-white shadow-sm flex items-center justify-center text-[8px] font-bold text-slate-500">+{{ $product->variants->count() - 5 }}</div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Hover overlay arrow (clickable) -->
                                    <a href="{{ route('product.show', $product->id) }}" class="absolute inset-0 bg-brand-900/0 group-hover:bg-brand-900/20 transition-colors duration-300 flex items-center justify-center z-10">
                                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg -translate-y-2 group-hover:translate-y-0">
                                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </div>
                                    </a>
                                </div>
                                
                                <!-- Card Content -->
                                <div class="p-5 flex-1 flex flex-col">
                                    <div class="mb-3 flex-1">
                                        <h3 class="font-outfit font-bold text-brand-900 text-base mb-1 line-clamp-1">
                                            <a href="{{ route('product.show', $product->id) }}" class="hover:text-brand-600 transition-colors">{{ $product->name }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                                    </div>
                                    
                                    @if($product->fabric_type)
                                        <div class="flex gap-2 mb-3 flex-wrap">
                                            <span class="text-[10px] bg-brand-50 text-brand-600 font-bold px-2 py-0.5 rounded-full">{{ $product->fabric_type }}</span>
                                        </div>
                                    @endif

                                    <div class="pt-4 border-t border-brand-50 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Per Meter</span>
                                            <span class="font-outfit font-extrabold text-lg text-brand-600">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                        <a href="{{ route('product.show', $product->id) }}" class="px-4 py-2 bg-brand-50 text-brand-600 hover:bg-brand-600 hover:text-white rounded-xl font-bold text-sm transition-all duration-200 shadow-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 text-brand-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-auto rounded-lg object-contain">
                    <div class="flex gap-2">
                        <a href="#" class="w-8 h-8 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Instagram">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-8 h-8 bg-green-700 hover:bg-green-600 rounded-lg flex items-center justify-center text-green-200 hover:text-white transition-all" title="WhatsApp">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
                <p class="text-brand-500 text-sm">&copy; {{ date('Y') }} Toko Kain Nelly. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>