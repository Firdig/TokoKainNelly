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
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-brand-900/50 z-20 xl:hidden" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="w-64 bg-brand-900 text-white h-screen fixed left-0 top-0 flex flex-col transition-transform duration-300 z-30 shadow-2xl shadow-brand-900/50 xl:translate-x-0">
        <div class="h-16 xl:h-20 flex items-center justify-center border-b border-brand-800">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-10 w-10 rounded-lg object-cover shadow-lg">
                <span class="font-outfit font-bold text-xl tracking-tight">Admin Panel</span>
            </a>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
            <div class="space-y-2 mb-4">
                <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-brand-300 hover:bg-brand-800 hover:text-white border border-brand-800">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Lihat Website</span>
                </a>
                <a href="{{ url('/kasir') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-brand-300 hover:bg-brand-800 hover:text-white border border-brand-800">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Kasir (POS)</span>
                </a>
            </div>

            <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            @if(Auth::user()->role === 'admin')
            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Master Data</div>
            
            <a href="{{ url('/admin/products') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/products*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Katalog Produk</span>
            </a>

            <a href="{{ url('/admin/categories') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/categories*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <span>Kategori Produk</span>
            </a>

            {{-- Dinonaktifkan: tidak termasuk dalam Use Case Diagram
            <a href="{{ url('/admin/customers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/customers*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Data Pelanggan</span>
            </a>
            --}}

            <a href="{{ url('/admin/users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/users*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Manajemen User</span>
            </a>
            @endif

            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Operasional</div>

            <a href="{{ url('/admin/orders') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/orders*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Pesanan (Orders)</span>
                </span>
                @if(($pendingOnlineOrders ?? 0) > 0)
                <span class="w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full shadow-sm">
                    {{ $pendingOnlineOrders }}
                </span>
                @endif
            </a>

            <a href="{{ url('/admin/scanner') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/scanner*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span>Scanner BOPS</span>
            </a>

            <a href="{{ url('/admin/restock') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/restock*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Penerimaan Stok</span>
            </a>

            {{-- Dinonaktifkan: tidak termasuk dalam Use Case Diagram
            <a href="{{ url('/admin/stock-opname') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/stock-opname*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Stock Audit</span>
            </a>
            --}}

            <div class="pt-4 pb-2 px-4 text-xs font-bold text-brand-500 uppercase tracking-wider">Laporan</div>

            @if(Auth::user()->role === 'admin')
            <a href="{{ url('/admin/report-center') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->is('admin/report-center*') ? 'bg-brand-600 text-white font-bold' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Pusat Laporan</span>
            </a>
            @endif

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
    <div class="xl:ml-64 flex-1 flex flex-col min-h-screen w-full transition-all duration-300">
        
        <!-- Top Navbar -->
        <header class="h-16 xl:h-20 bg-white border-b border-brand-100 flex items-center justify-between px-4 md:px-6 lg:px-8 sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="xl:hidden p-2 rounded-lg text-brand-600 hover:bg-brand-50 transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-bold font-outfit text-brand-900">@yield('title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Notification Bell -->
                @if(($pendingOnlineOrders ?? 0) > 0)
                <a href="{{ url('/admin/orders?status=pending') }}" class="relative p-2 rounded-lg text-brand-600 hover:bg-brand-50 transition-colors" title="Pesanan online menunggu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute -top-1 -right-1 w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full shadow-sm">
                        {{ $pendingOnlineOrders }}
                    </span>
                </a>
                @endif

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
        <main class="flex-1 p-4 md:p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
