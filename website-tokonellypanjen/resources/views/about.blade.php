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
                    <p class="text-slate-500 leading-relaxed mb-6">Dengan 4 cabang yang tersebar di wilayah Malang Selatan — Kepanjen, Gondanglegi, Turen, dan Bululawang — kami berkomitmen untuk mendekatkan produk kain berkualitas ke masyarakat dengan harga yang terjangkau dan pelayanan yang ramah.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                            <div class="font-outfit font-extrabold text-3xl text-brand-600 mb-1">4</div>
                            <div class="text-sm text-slate-500 font-medium">Cabang Toko</div>
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
                        <p class="text-slate-500 leading-relaxed">Menjadi toko kain terpercaya dan terlengkap di wilayah Malang Selatan yang mengutamakan kualitas, pelayanan, dan kepuasan pelanggan.</p>
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
                    <h2 class="text-3xl font-extrabold text-brand-900 font-outfit">4 Cabang di Malang Selatan</h2>
                    <p class="text-slate-500 mt-3 max-w-xl mx-auto">Kunjungi cabang terdekat kami untuk melihat koleksi kain secara langsung.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Branch 1: Kepanjen (Active) -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border-2 border-brand-400 relative overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="absolute top-4 right-4">
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Online</span>
                        </div>
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Cabang Kepanjen</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Pasar Kepanjen No. 12, Kepanjen, Kab. Malang</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0812-3456-7890</p>
                            <p>🕐 Senin – Sabtu, 08.00–17.00</p>
                        </div>
                    </div>
                    <!-- Branch 2: Gondanglegi -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Cabang Gondanglegi</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Raya Gondanglegi No. 45, Gondanglegi, Kab. Malang</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0812-3456-7891</p>
                            <p>🕐 Senin – Sabtu, 08.00–17.00</p>
                        </div>
                    </div>
                    <!-- Branch 3: Turen -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Cabang Turen</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Pasar Turen No. 23, Turen, Kab. Malang</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0812-3456-7892</p>
                            <p>🕐 Senin – Sabtu, 08.00–17.00</p>
                        </div>
                    </div>
                    <!-- Branch 4: Bululawang -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Cabang Bululawang</h3>
                        <p class="text-sm text-slate-500 mb-3">Jl. Raya Bululawang No. 8, Bululawang, Kab. Malang</p>
                        <div class="text-xs text-slate-400 space-y-1">
                            <p>📞 0812-3456-7893</p>
                            <p>🕐 Senin – Sabtu, 08.00–17.00</p>
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
    <footer class="bg-brand-950 text-brand-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-auto rounded-lg object-contain">
                    <div class="flex gap-2">
                        <a href="#" class="w-8 h-8 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Instagram"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        <a href="#" class="w-8 h-8 bg-brand-800 hover:bg-brand-600 rounded-lg flex items-center justify-center text-brand-300 hover:text-white transition-all" title="Facebook"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#" class="w-8 h-8 bg-green-700 hover:bg-green-600 rounded-lg flex items-center justify-center text-green-200 hover:text-white transition-all" title="WhatsApp"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                    </div>
                </div>
                <p class="text-brand-500 text-sm">&copy; {{ date('Y') }} Toko Kain Nelly. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
