<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex items-center justify-center p-4 py-12">

    <div class="max-w-md w-full relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 bg-brand-900 rounded-xl flex items-center justify-center text-white font-bold text-3xl shadow-lg relative overflow-hidden">
                    <span class="relative z-10 font-outfit">N</span>
                </div>
                <span class="font-outfit font-bold text-3xl text-brand-900 tracking-tight">Toko Nelly</span>
            </a>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-brand-100 relative overflow-hidden">
             <!-- Decorative blur -->
             <div class="absolute -top-10 -left-10 w-32 h-32 bg-brand-100 rounded-full blur-3xl opacity-50"></div>

             <div class="relative z-10">
                <h1 class="text-2xl font-bold text-brand-900 font-outfit mb-2 text-center">Buat Akun Baru</h1>
                <p class="text-slate-500 text-center mb-8 text-sm">Bergabunglah dan jelajahi koleksi kain terlengkap kami.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50 @error('name') border-red-500 @enderror" placeholder="John Doe">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50 @error('email') border-red-500 @enderror" placeholder="email@contoh.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-2">Kata Sandi</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50" placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-2">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50" placeholder="Ketik ulang kata sandi">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 bg-brand-900 hover:bg-brand-950 text-white rounded-xl font-bold font-outfit text-lg shadow-xl shadow-brand-900/20 hover:-translate-y-0.5 transition-all">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm text-slate-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-800 transition-colors underline decoration-2 underline-offset-4 decoration-brand-200 hover:decoration-brand-600">Masuk di sini</a>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
