<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex items-center justify-center p-4">

    <div class="max-w-md w-full relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="w-14 h-14 rounded-xl object-cover shadow-lg">
                <span class="font-outfit font-bold text-3xl text-brand-900 tracking-tight">Toko Nelly</span>
            </a>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-brand-100 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-100 rounded-full blur-3xl opacity-50"></div>
            
            <div class="relative z-10">
                <h1 class="text-2xl font-bold text-brand-900 font-outfit mb-2 text-center">Selamat Datang</h1>
                <p class="text-slate-500 text-center mb-8 text-sm leading-relaxed">Masuk ke akun Anda untuk pengalaman berbelanja terbaik, atau akses dashboard admin.</p>

                @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-brand-900 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50 @error('email') border-red-500 @enderror" placeholder="email@contoh.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-bold text-brand-900">Kata Sandi</label>
                        </div>
                        <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors bg-brand-50" placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-brand-900 hover:bg-brand-950 text-white rounded-xl font-bold font-outfit text-lg shadow-xl shadow-brand-900/20 hover:-translate-y-0.5 transition-all">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm text-slate-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-800 transition-colors underline decoration-2 underline-offset-4 decoration-brand-200 hover:decoration-brand-600">Daftar sekarang</a>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
