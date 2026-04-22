<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Nelly Panjen - Kain Berkualitas Terbaik</title>
    <meta name="description" content="Temukan koleksi kain premium terlengkap di Toko Nelly Panjen. Kain batik, katun, satin, dan banyak lagi dengan harga terjangkau.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen flex flex-col font-sans">

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
                <!-- Navigation Component -->
                <x-frontend-navbar />
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 md:pt-44 md:pb-32 overflow-hidden bg-mesh">
        <!-- Background Shapes -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-200/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-brand-300/20 rounded-full blur-3xl"></div>
        </div>
        <!-- Diagonal decoration -->
        <div class="absolute bottom-0 left-0 right-0 h-24 bg-white" style="clip-path: polygon(0 60%, 100% 0, 100% 100%, 0 100%)"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-100 text-brand-700 text-sm font-semibold mb-8 border border-brand-200 animate-fade-in shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse-slow"></span>
                    Koleksi Terbaru 2026 — Tersedia Sekarang
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-brand-900 font-outfit mb-6 tracking-tight leading-[1.1] animate-fade-in delay-100">
                    Kain Berkualitas,<br>
                    <span class="text-gradient-blue">Gaya Tak Terbatas.</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-in delay-200">
                    Temukan koleksi tekstil premium pilihan untuk fashion, dekorasi, dan seragam batik terbaik di Kepanjen, Malang.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in delay-300">
                    <a href="{{ route('katalog') }}" class="btn-primary text-center text-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Belanja Sekarang
                    </a>
                    <a href="#koleksi" class="btn-outline text-center text-lg flex items-center justify-center gap-2">
                        Lihat Koleksi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Strip -->
    <section class="bg-white py-12 border-b border-brand-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0 md:divide-x divide-brand-100">
                <div class="flex flex-col items-center text-center px-6">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-3 text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div class="font-outfit font-bold text-brand-900 text-sm md:text-base">Kualitas Premium</div>
                    <div class="text-xs text-slate-400 mt-1">Terseleksi ketat</div>
                </div>
                <div class="flex flex-col items-center text-center px-6">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-3 text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div class="font-outfit font-bold text-brand-900 text-sm md:text-base">Harga Terbaik</div>
                    <div class="text-xs text-slate-400 mt-1">Per meter terjangkau</div>
                </div>
                <div class="flex flex-col items-center text-center px-6">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-3 text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="font-outfit font-bold text-brand-900 text-sm md:text-base">Ambil di Toko</div>
                    <div class="text-xs text-slate-400 mt-1">BOPS tersedia</div>
                </div>
                <div class="flex flex-col items-center text-center px-6">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-3 text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="font-outfit font-bold text-brand-900 text-sm md:text-base">Beragam Motif</div>
                    <div class="text-xs text-slate-400 mt-1">Ratusan pilihan warna</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Products Section -->
    <section id="koleksi" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Koleksi Pilihan</div>
                <h2 class="section-title">Produk Terpopuler</h2>
                <div class="w-16 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600 mx-auto mt-5 rounded-full"></div>
                <p class="text-slate-500 mt-4 max-w-xl mx-auto">Kain-kain terlaris yang dipilih pelanggan setiap minggu — tersedia dalam berbagai pilihan warna dan motif.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                <a href="{{ route('product.show', $product->id) }}" class="group bg-white rounded-2xl border border-brand-100 shadow-sm hover:shadow-2xl hover:shadow-brand-600/10 hover:border-brand-300 transition-all duration-300 overflow-hidden flex flex-col hover:-translate-y-2">
                    <!-- Image Placeholder w/ fallback -->
                    <div class="h-52 bg-gradient-to-br from-brand-50 to-amber-50 relative overflow-hidden">
                        @php
                            $img = null;
                            if(isset($product->images) && $product->images->count() > 0) $img = $product->images->first()->image_path;
                            elseif($product->variants->whereNotNull('image_path')->count() > 0) $img = $product->variants->whereNotNull('image_path')->first()->image_path;
                        @endphp
                        @if($img)
                            <img src="{{ Storage::url($img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-16 h-16 text-brand-200 group-hover:text-brand-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                        @endif
                        @if($loop->first)
                            <span class="absolute top-3 left-3 bg-brand-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md uppercase tracking-wide">Terlaris</span>
                        @endif
                        <!-- Color Bubbles -->
                        @if($product->variants->count() > 0)
                            <div class="absolute bottom-3 right-3 flex -space-x-1.5">
                                @foreach($product->variants->take(4) as $v)
                                    <div class="w-5 h-5 rounded-full border-2 border-white shadow" style="background-color: {{ $v->hex_code ?? '#ccc' }}" title="{{ $v->color_name }}"></div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-outfit font-bold text-brand-900 text-base mb-1 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed flex-1">{{ $product->description }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-brand-50 flex items-center justify-between">
                            <div>
                                <div class="text-[10px] text-slate-400 uppercase font-medium">Per Meter</div>
                                <div class="font-outfit font-extrabold text-lg text-brand-600">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-brand-50 group-hover:bg-brand-600 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-brand-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-14 text-center">
                <a href="{{ route('katalog') }}" class="btn-outline inline-flex items-center gap-2">
                    Lihat Semua Koleksi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="bg-gradient-to-br from-brand-700 to-brand-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full border-[40px] border-white -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full border-[30px] border-white translate-y-1/2 -translate-x-1/4"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white font-outfit mb-4">Butuh Kain Dalam Jumlah Besar?</h2>
            <p class="text-brand-200 text-lg mb-8">Hubungi kami untuk harga grosir dan ketersediaan stok. Pelayanan ramah, pengiriman cepat.</p>
            <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 font-bold text-lg px-8 py-4 rounded-xl hover:bg-brand-50 shadow-xl shadow-brand-900/30 transition-all hover:-translate-y-0.5">
                Mulai Berbelanja
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-950 text-brand-100 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between gap-10 pb-12 border-b border-brand-800">
                <div class="max-w-xs">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-10 w-10 rounded-xl object-cover">
                        <span class="font-outfit font-bold text-2xl text-white">Toko Nelly</span>
                    </div>
                    <p class="text-brand-400 text-sm leading-relaxed">Menyediakan berbagai macam kain berkualitas untuk fashion dan dekorasi. Jl. Kepanjen, Malang, Jawa Timur.</p>
                </div>
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-outfit font-bold text-white mb-4 text-sm uppercase tracking-wider">Layanan</h4>
                        <ul class="space-y-2 text-sm text-brand-400">
                            <li><a href="{{ route('katalog') }}" class="hover:text-white transition-colors">Katalog Kain</a></li>
                            <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Keranjang Belanja</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-outfit font-bold text-white mb-4 text-sm uppercase tracking-wider">Kontak</h4>
                        <ul class="space-y-2 text-sm text-brand-400">
                            <li>Kepanjen, Malang</li>
                            <li>Senin – Sabtu, 08.00–17.00</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pt-8 text-center text-sm text-brand-600">
                &copy; {{ date('Y') }} Toko Kain Nelly Panjen. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
