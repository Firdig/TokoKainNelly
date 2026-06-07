<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Toko Kain Nelly</title>
    <meta name="description" content="Kenali lebih dekat Toko Kain Nelly — pusat grosir dan eceran kain berkualitas dengan 4 cabang di wilayah Malang Selatan.">
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
                <x-frontend-navbar />
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <div class="bg-gradient-to-br from-brand-800 to-brand-600 pt-28 pb-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/2 left-1/3 w-96 h-96 rounded-full border-[30px] border-white -translate-y-1/2"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white font-outfit mb-3 tracking-tight">Tentang Kami</h1>
            <p class="text-brand-200 text-lg max-w-xl mx-auto">Mengenal lebih dekat Toko Kain Nelly — mitra terpercaya Anda untuk kain berkualitas.</p>
        </div>
    </div>

    <main class="flex-1 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- About Section -->
            <section class="md:flex items-center gap-16 mb-20">
                <div class="md:w-5/12 mb-10 md:mb-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="w-72 h-72 mx-auto md:mx-0 rounded-3xl object-cover shadow-2xl shadow-brand-400/20 ring-4 ring-brand-100">
                </div>
                <div class="md:w-7/12">
                    <div class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Tentang Kami</div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 font-outfit mb-6 leading-tight">Pusat Grosir & Eceran Kain Berkualitas Tinggi</h2>
                    <p class="text-slate-500 leading-relaxed mb-4">Toko Kain Nelly merupakan toko kain yang telah berpengalaman dalam menyediakan berbagai macam jenis kain berkualitas tinggi. Kami menyediakan kain untuk berbagai kebutuhan — mulai dari fashion, dekorasi rumah, seragam kantor, hingga keperluan jahit sehari-hari.</p>
                    <p class="text-slate-500 leading-relaxed mb-6">Dengan 4 Toko yang tersebar di malang — kami berkomitmen untuk mendekatkan produk kain berkualitas ke masyarakat dengan harga yang terjangkau dan pelayanan yang ramah.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                            <div class="font-outfit font-extrabold text-3xl text-brand-600 mb-1">4</div>
                            <div class="text-sm text-slate-500 font-medium">Toko</div>
                        </div>
                        <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                            <div class="font-outfit font-extrabold text-3xl text-brand-600 mb-1">100+</div>
                            <div class="text-sm text-slate-500 font-medium">Jenis Kain Tersedia</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Vision & Mission -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <div class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Visi & Misi</div>
                    <h2 class="text-3xl font-extrabold text-brand-900 font-outfit">Komitmen Kami untuk Anda</h2>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mb-5 text-brand-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-brand-900 mb-3">Visi</h3>
                        <p class="text-slate-500 leading-relaxed">Menjadi toko kain terpercaya dan terlengkap di wilayah Malang yang mengutamakan kualitas, pelayanan, dan kepuasan pelanggan.</p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mb-5 text-brand-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-xl text-brand-900 mb-3">Misi</h3>
                        <ul class="text-slate-500 leading-relaxed space-y-2">
                            <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400 mt-2 shrink-0"></span>Menyediakan kain dengan kualitas terbaik dan harga yang kompetitif</li>
                            <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400 mt-2 shrink-0"></span>Memberikan pelayanan yang ramah, cepat, dan profesional</li>
                            <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400 mt-2 shrink-0"></span>Memperluas jangkauan melalui layanan online dan pengiriman</li>
                            <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-brand-400 mt-2 shrink-0"></span>Menjaga hubungan baik dengan pelanggan dan pemasok</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Branch Locations -->
            <section>
                <div class="text-center mb-12">
                    <div class="inline-block bg-brand-100 text-brand-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">Lokasi Kami</div>
                    <h2 class="text-3xl font-extrabold text-brand-900 font-outfit">4 Toko di Malang</h2>
                    <p class="text-slate-500 mt-3 max-w-xl mx-auto">Kunjungi cabang terdekat kami untuk melihat koleksi kain secara langsung.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Branch 1: Kepanjen (Active) -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">(Pusat) Toko Nelly Pasar Besar</h3>
                        <p class="text-sm text-slate-500 mb-3">Pasar Besar Malang LT.1, Blok Barat Utara C Jl. Pasar Besar No.21 10-18, Sukoharjo, Kec. Klojen, Kota Malang, Jawa Timur 65118</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0821-3333-1111</p>
                            <p>🕐 Senin - Minggu, 08.30–16.00</p>
                        </div>
                    </div>
                    <!-- Branch 2: Gondanglegi -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">(Cabang) Toko Nelly Kepanjen</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Pasar Kepanjen No. 12, Kepanjen, Kab. Malang</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0821-3333-2222</p>
                            <p>🕐 Senin - Minggu, 08.30–16.00</p>
                        </div>
                    </div>
                    <!-- Branch 3: Turen -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">(Cabang) Toko Nelly RUKO Pecinan</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Pecinan Square No.21-23, Sukoharjo, Kec. Klojen, Kota Malang, Jawa Timur 65118</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0821-3333-3333</p>
                            <p>🕐 Senin - Minggu, 08.30–16.00</p>
                        </div>
                    </div>
                    <!-- Branch 4: Bululawang -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">(Cabang) Toko Nelly Blimbing</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Laksda Adi Sucipto No.85, Blimbing, Kec. Blimbing, Kota Malang, Jawa Timur 65126</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0821-3333-4444</p>
                            <p>🕐 Senin - Minggu, 08.30–16.00</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-400 italic">* Saat ini layanan online (website) hanya tersedia untuk Cabang Kepanjen. Cabang lainnya hanya melayani pembelian langsung di toko.</p>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <x-frontend-footer />

</body>
</html>
