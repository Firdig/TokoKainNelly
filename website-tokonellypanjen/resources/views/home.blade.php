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
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-14 w-auto rounded-xl object-contain">
                    <span class="font-outfit font-bold text-xl text-brand-900 tracking-tight">Toko Kain Nelly</span>
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

    <!-- About Store Introduction -->
    <section class="py-20 bg-white relative overflow-hidden">
        <div class="absolute -right-32 top-0 w-96 h-96 bg-brand-100/30 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="md:flex items-center gap-16">
                <div class="md:w-5/12 mb-10 md:mb-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="w-64 h-64 mx-auto md:mx-0 rounded-3xl object-cover shadow-2xl shadow-brand-400/20 ring-4 ring-brand-100">
                </div>
                <div class="md:w-7/12">
                    <div class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Tentang Kami</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 font-outfit mb-6 leading-tight">Toko Kain Nelly — <br>Pusat Grosir & Eceran Kain <span class="text-gradient-blue">Sejak Lama</span></h2>
                    <p class="text-slate-500 leading-relaxed mb-6">Toko Kain Nelly merupakan toko kain yang menyediakan berbagai macam jenis kain berkualitas tinggi untuk kebutuhan fashion, dekorasi, seragam, dan keperluan jahit lainnya. Dengan 4 cabang yang tersebar di wilayah Malang Selatan, kami berkomitmen memberikan pelayanan terbaik dengan harga yang terjangkau.</p>
                    <div class="flex flex-wrap gap-6 mb-8">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <div class="font-outfit font-bold text-brand-900 text-lg">4 Cabang</div>
                                <div class="text-xs text-slate-400">Wilayah Malang Selatan</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div>
                                <div class="font-outfit font-bold text-brand-900 text-lg">Ratusan Kain</div>
                                <div class="text-xs text-slate-400">Beragam jenis & motif</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="btn-outline inline-flex items-center gap-2 text-sm">
                        Selengkapnya Tentang Kami
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
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
                            if(isset($product->images) && $product->images->count() > 0 && $product->images->first()->image_mime) $img = route('image.gallery', $product->images->first()->id);
                            elseif($product->variants->whereNotNull('image_mime')->count() > 0) $img = route('image.variant', $product->variants->whereNotNull('image_mime')->first()->id);
                        @endphp
                        @if($img)
                            <div class="absolute inset-0 skeleton-loader z-0"></div>
                            <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy" onload="this.classList.remove('opacity-0'); this.previousElementSibling.remove();" class="w-full h-full object-cover transition-all duration-700 opacity-0 group-hover:scale-110 relative z-10">
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

    <!-- Contact Us CTA -->
    <section class="bg-gradient-to-br from-brand-700 to-brand-900 py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full border-[40px] border-white -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full border-[30px] border-white translate-y-1/2 -translate-x-1/4"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white font-outfit mb-4">Ada Pertanyaan atau Butuh Bantuan?</h2>
            <p class="text-brand-200 text-lg mb-8">Hubungi kami untuk informasi produk, harga grosir, ketersediaan stok, dan lokasi cabang terdekat. Tim kami siap membantu Anda.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 font-bold text-lg px-8 py-4 rounded-xl hover:bg-brand-50 shadow-xl shadow-brand-900/30 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Hubungi Kami
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-950 text-brand-100 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-brand-800">
                <!-- Brand Column -->
                <div class="md:col-span-1">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-20 w-auto rounded-xl object-contain mb-4">
                    <p class="text-brand-400 text-sm leading-relaxed mb-5">Pusat grosir & eceran kain berkualitas dengan 4 cabang di wilayah Malang Selatan.</p>
                    <!-- Social Media Icons -->
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="TikTok">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-green-700 hover:bg-green-600 rounded-lg flex items-center justify-center text-green-200 hover:text-white transition-all" title="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
                <!-- Navigation -->
                <div>
                    <h4 class="font-outfit font-bold text-white mb-4 text-sm uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-brand-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('katalog') }}" class="hover:text-white transition-colors">Katalog Kain</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>
                <!-- Cabang -->
                <div>
                    <h4 class="font-outfit font-bold text-white mb-4 text-sm uppercase tracking-wider">Cabang Kami</h4>
                    <ul class="space-y-2.5 text-sm text-brand-400">
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 mt-1.5 shrink-0"></span>
                            <span>Kepanjen <span class="text-brand-600 text-xs">(Online)</span></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mt-1.5 shrink-0"></span>
                            <span>Gondanglegi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mt-1.5 shrink-0"></span>
                            <span>Turen</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-500 mt-1.5 shrink-0"></span>
                            <span>Bululawang</span>
                        </li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div>
                    <h4 class="font-outfit font-bold text-white mb-4 text-sm uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-2.5 text-sm text-brand-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@tokokainnelly.com</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Senin – Sabtu, 08.00–17.00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 text-center text-sm text-brand-600">
                &copy; {{ date('Y') }} Toko Kain Nelly. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
