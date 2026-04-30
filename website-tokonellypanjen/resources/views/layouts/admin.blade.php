<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-brand-50 min-h-screen font-sans flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-brand-900 text-white min-h-screen fixed left-0 top-0 flex flex-col transition-all z-20 shadow-2xl shadow-brand-900/50">
        <div class="h-20 flex items-center justify-center border-b border-brand-800">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-10 w-10 rounded-lg object-cover shadow-lg">
                <span class="font-outfit font-bold text-xl tracking-tight">Admin Panel</span>
            </a>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Master Data</div>
            
            <a href="{{ url('/admin/products') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/products*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Katalog Produk</span>
            </a>

            <a href="{{ url('/admin/users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/users*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Manajemen User</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Operasional</div>

            <a href="{{ url('/admin/orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/orders*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span>Pesanan (Orders)</span>
            </a>

            <a href="{{ url('/admin/scanner') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/scanner*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span>Scanner BOPS</span>
            </a>

            <a href="{{ url('/admin/stock-opname') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/stock-opname*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Stock Opname</span>
            </a>

            <a href="{{ url('/admin/stock-report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/stock-report*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Laporan Stok</span>
            </a>
            
            <a href="{{ url('/laporan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('laporan') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-2z"></path></svg>
                <span>Laporan Kasir</span>
            </a>
        </nav>

        <div class="p-4 border-t border-brand-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content wrapper -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-brand-100 flex items-center justify-between px-8 sticky top-0 z-10 shadow-sm">
            <h1 class="text-xl font-bold font-outfit text-brand-900">@yield('title', 'Dashboard')</h1>
            
            <div class="flex items-center gap-6">
                <!-- Branch Selector -->
                <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-brand-50 rounded-lg border border-brand-100">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-sm font-bold text-brand-900">Toko Utama (Kepanjen)</span>
                </div>
                
                <!-- Profile -->
                <div class="flex items-center gap-3 border-l border-brand-100 pl-6">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-bold text-brand-900">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-xs text-slate-500 capitalize">{{ Auth::user()->role ?? 'Admin' }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold font-outfit text-lg border-2 border-white shadow-sm">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
