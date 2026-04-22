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
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-12 rounded-xl object-cover shadow-lg shadow-brand-600/20 ring-1 ring-brand-200/50">
                    <div>
                        <span class="font-outfit font-bold text-xl text-brand-900 tracking-tight block leading-none">Toko Nelly</span>
                        <span class="text-[10px] text-brand-400 font-medium tracking-widest uppercase">Panjen, Malang</span>
                    </div>
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
                                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kain..." class="input-field pl-10 text-sm py-2.5">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
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

                            <!-- Texture Filter -->
                            @if(isset($textures) && $textures->count() > 0)
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Tekstur</label>
                                <select name="texture" class="input-field text-sm py-2.5 bg-white" onchange="this.form.submit()">
                                    <option value="">Semua Tekstur</option>
                                    @foreach($textures as $tex)
                                        <option value="{{ $tex }}" {{ request('texture') == $tex ? 'selected' : '' }}>{{ $tex }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <!-- Color Filter -->
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Warna</label>
                                <input type="text" name="color" value="{{ request('color') }}" placeholder="Cari warna..." class="input-field text-sm py-2.5">
                            </div>

                            <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-colors flex items-center justify-center gap-2 shadow-md shadow-brand-600/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Cari
                            </button>

                            @if(request()->has('q') || request()->has('sort') || request()->has('fabric_type') || request()->has('texture') || request()->has('color'))
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
                                        if($product->images->count() > 0) { $primaryImage = $product->images->first()->image_path; }
                                        elseif($product->variants->whereNotNull('image_path')->count() > 0) { $primaryImage = $product->variants->whereNotNull('image_path')->first()->image_path; }
                                    @endphp
                                    
                                    @if($primaryImage)
                                        <img src="{{ Storage::url($primaryImage) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
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

                                    <!-- Hover overlay arrow -->
                                    <div class="absolute inset-0 bg-brand-900/0 group-hover:bg-brand-900/20 transition-colors duration-300 flex items-center justify-center">
                                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg -translate-y-2 group-hover:translate-y-0">
                                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Content -->
                                <div class="p-5 flex-1 flex flex-col">
                                    <div class="mb-3 flex-1">
                                        <h3 class="font-outfit font-bold text-brand-900 text-base mb-1 line-clamp-1">
                                            <a href="{{ route('product.show', $product->id) }}" class="hover:text-brand-600 transition-colors">{{ $product->name }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                                    </div>
                                    
                                    @if($product->texture || $product->composition)
                                        <div class="flex gap-2 mb-3 flex-wrap">
                                            @if($product->texture)
                                                <span class="text-[10px] bg-brand-50 text-brand-600 font-bold px-2 py-0.5 rounded-full">{{ $product->texture }}</span>
                                            @endif
                                            @if($product->composition)
                                                <span class="text-[10px] bg-slate-50 text-slate-500 font-bold px-2 py-0.5 rounded-full">{{ $product->composition }}</span>
                                            @endif
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-8 w-8 rounded-lg object-cover">
                <span class="font-outfit font-bold text-lg text-white">Toko Nelly Panjen</span>
            </div>
            <p class="text-brand-500 text-sm">&copy; {{ date('Y') }} Toko Kain Nelly Panjen. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>