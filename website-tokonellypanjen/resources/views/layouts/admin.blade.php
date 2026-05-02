<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-brand-50 min-h-screen font-sans flex">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-brand-900/50 z-20 md:hidden" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-64 bg-brand-900 text-white h-screen fixed left-0 top-0 flex flex-col transition-transform duration-300 z-30 shadow-2xl shadow-brand-900/50 md:translate-x-0">
        <div class="h-20 flex items-center justify-center border-b border-brand-800">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-10 w-10 rounded-lg object-cover shadow-lg">
                <span class="font-outfit font-bold text-xl tracking-tight">Admin Panel</span>
            </a>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-brand-300 hover:bg-brand-800 hover:text-white mb-4 border border-brand-800">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>Lihat Website</span>
            </a>

            <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Master Data</div>
            
            <a href="{{ url('/admin/products') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/products*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Katalog Produk</span>
            </a>

            <a href="{{ url('/admin/customers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/customers*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Data Pelanggan</span>
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

            <a href="{{ url('/admin/restock') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/restock*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Penerimaan Stok</span>
            </a>

            <a href="{{ url('/admin/stock-opname') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/stock-opname*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Stock Audit</span>
            </a>

            <a href="{{ url('/admin/stock-report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/stock-report*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>Laporan Stok</span>
            </a>
            
            <a href="{{ url('/admin/sales-report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/sales-report*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Laporan Penjualan</span>
            </a>

            <a href="{{ url('/admin/product-sales-report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/product-sales-report*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Penjualan Per Produk</span>
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
    <div class="md:ml-64 flex-1 flex flex-col min-h-screen w-full transition-all duration-300">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-brand-100 flex items-center justify-between px-4 md:px-8 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg text-brand-600 hover:bg-brand-50 transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-bold font-outfit text-brand-900">@yield('title', 'Dashboard')</h1>
            </div>
            
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
