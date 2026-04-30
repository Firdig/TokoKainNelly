<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Toko Kain Nelly</title>
    <meta name="description" content="Hubungi Toko Kain Nelly untuk informasi produk, harga grosir, dan lokasi cabang terdekat.">
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
            <div class="absolute top-1/2 right-1/4 w-80 h-80 rounded-full border-[30px] border-white -translate-y-1/2"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white font-outfit mb-3 tracking-tight">Hubungi Kami</h1>
            <p class="text-brand-200 text-lg max-w-xl mx-auto">Ada pertanyaan? Kami siap membantu Anda. Hubungi kami melalui berbagai saluran komunikasi.</p>
        </div>
    </div>

    <main class="flex-1 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Contact Cards -->
            <div class="grid sm:grid-cols-3 gap-6 mb-16">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 text-center hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-5 text-brand-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Telepon</h3>
                    <p class="text-brand-600 font-bold text-lg">0812-3456-7890</p>
                    <p class="text-sm text-slate-400 mt-1">Senin – Sabtu, 08.00–17.00</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 text-center hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-5 text-green-600">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">WhatsApp</h3>
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-green-600 font-bold text-lg hover:text-green-700 transition-colors">Chat Sekarang</a>
                    <p class="text-sm text-slate-400 mt-1">Respon cepat via WhatsApp</p>
                </div>
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-100 text-center hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-5 text-brand-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-brand-900 mb-2">Email</h3>
                    <p class="text-brand-600 font-bold">info@tokokainnelly.com</p>
                    <p class="text-sm text-slate-400 mt-1">Respon dalam 1x24 jam</p>
                </div>
            </div>

            <!-- Contact Form + Map -->
            <div class="md:flex gap-8 mb-16">
                <!-- Form -->
                <div class="flex-1 bg-white rounded-3xl p-8 shadow-sm border border-brand-100 mb-8 md:mb-0">
                    <h2 class="font-outfit font-bold text-2xl text-brand-900 mb-2">Kirim Pesan</h2>
                    <p class="text-slate-400 text-sm mb-8">Isi formulir di bawah ini dan kami akan segera menghubungi Anda.</p>
                    
                    <form class="space-y-5">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-brand-900 mb-2">Nama Lengkap</label>
                                <input type="text" placeholder="Masukkan nama Anda" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-brand-900 mb-2">Nomor Telepon</label>
                                <input type="text" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-brand-900 mb-2">Email</label>
                            <input type="email" placeholder="email@contoh.com" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-brand-900 mb-2">Subjek</label>
                            <select class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm text-brand-900 appearance-none bg-white">
                                <option>Informasi Produk</option>
                                <option>Harga Grosir</option>
                                <option>Ketersediaan Stok</option>
                                <option>Kerjasama</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-brand-900 mb-2">Pesan</label>
                            <textarea rows="4" placeholder="Tulis pesan Anda di sini..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm resize-none"></textarea>
                        </div>
                        <button type="button" onclick="alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.')" class="w-full py-3.5 bg-gradient-to-r from-brand-600 to-brand-700 text-white rounded-xl font-bold font-outfit hover:from-brand-700 hover:to-brand-800 transition-all shadow-lg shadow-brand-600/30 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Branch Info -->
                <div class="md:w-96 space-y-4">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100">
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Cabang
                        </h3>
                        <div class="space-y-5">
                            <div class="pl-4 border-l-2 border-brand-400">
                                <h4 class="font-bold text-brand-900 text-sm">Cabang Kepanjen <span class="text-green-600 text-xs">(Online)</span></h4>
                                <p class="text-sm text-slate-500">Jl. Pasar Kepanjen No. 12, Kepanjen, Kab. Malang</p>
                            </div>
                            <div class="pl-4 border-l-2 border-brand-200">
                                <h4 class="font-bold text-brand-900 text-sm">Cabang Gondanglegi</h4>
                                <p class="text-sm text-slate-500">Jl. Raya Gondanglegi No. 45, Gondanglegi, Kab. Malang</p>
                            </div>
                            <div class="pl-4 border-l-2 border-brand-200">
                                <h4 class="font-bold text-brand-900 text-sm">Cabang Turen</h4>
                                <p class="text-sm text-slate-500">Jl. Pasar Turen No. 23, Turen, Kab. Malang</p>
                            </div>
                            <div class="pl-4 border-l-2 border-brand-200">
                                <h4 class="font-bold text-brand-900 text-sm">Cabang Bululawang</h4>
                                <p class="text-sm text-slate-500">Jl. Raya Bululawang No. 8, Bululawang, Kab. Malang</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100">
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Operasional
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Senin – Jumat</span>
                                <span class="font-bold text-brand-900">08.00 – 17.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Sabtu</span>
                                <span class="font-bold text-brand-900">08.00 – 15.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Minggu</span>
                                <span class="font-bold text-red-500">Tutup</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-100">
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Media Sosial
                        </h3>
                        <div class="flex gap-3">
                            <a href="#" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-br from-pink-500 to-purple-600 text-white rounded-xl text-sm font-bold hover:-translate-y-0.5 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                IG
                            </a>
                            <a href="#" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-xl text-sm font-bold hover:-translate-y-0.5 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                FB
                            </a>
                            <a href="#" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-brand-900 text-white rounded-xl text-sm font-bold hover:-translate-y-0.5 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                TT
                            </a>
                        </div>
                    </div>
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
