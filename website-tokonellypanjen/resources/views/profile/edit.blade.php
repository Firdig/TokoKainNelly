<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

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

    <main class="flex-1 pt-28 pb-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('home') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 hover:text-brand-600 hover:bg-brand-50 shadow-sm border border-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="font-outfit font-bold text-3xl text-brand-900 mb-1">Profil Saya</h1>
                    <p class="text-slate-500 text-sm">Kelola informasi pribadi dan alamat pengiriman Anda.</p>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm mb-6">
                <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm mb-6">
                @foreach($errors->all() as $error)
                <p class="text-sm text-red-700 font-bold">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div class="space-y-6">
                <!-- Profile Info -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-50">
                    <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Pribadi
                    </h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Alamat Pengiriman</label>
                            <textarea name="address" rows="2" id="profileAddress" placeholder="Masukkan alamat lengkap untuk pengiriman..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow resize-none">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Map for Address -->
                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Lokasi di Peta <span class="text-slate-400 font-normal normal-case">(klik peta untuk menandai)</span></label>
                            <div id="profileMap" class="w-full h-64 rounded-xl border border-slate-300 overflow-hidden z-0"></div>
                            <p class="text-xs text-slate-400 mt-1">Klik pada peta untuk menandai lokasi alamat Anda</p>
                        </div>

                        <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-lg shadow-brand-600/20 transition-all hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-50">
                    <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Ubah Kata Sandi
                    </h3>
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Kata Sandi Baru</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-900 mb-1.5 uppercase tracking-wide">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none transition-shadow">
                        </div>

                        <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold shadow-lg shadow-slate-800/20 transition-all hover:-translate-y-0.5">
                            Perbarui Kata Sandi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Default: Kepanjen, Malang
        const defaultLat = -8.1351;
        const defaultLng = 112.5689;
        const map = L.map('profileMap').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
        });

        // Fix Leaflet rendering in hidden/lazy containers
        setTimeout(() => map.invalidateSize(), 200);
    });
</script>

    <x-frontend-footer />

</body>
</html>
