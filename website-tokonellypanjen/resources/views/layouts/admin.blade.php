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
                <span id="sidebar-order-badge" class="w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full shadow-sm" @if(($pendingOnlineOrders ?? 0) == 0) style="display:none" @endif>
                    {{ $pendingOnlineOrders ?? 0 }}
                </span>
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
                <a id="header-bell-container" href="{{ url('/admin/orders?status=pending') }}" class="relative p-2 rounded-lg text-brand-600 hover:bg-brand-50 transition-colors" title="Pesanan online menunggu" @if(($pendingOnlineOrders ?? 0) == 0) style="display:none" @endif>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="notif-badge-count absolute -top-1 -right-1 w-5 h-5 flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full shadow-sm">
                        {{ $pendingOnlineOrders ?? 0 }}
                    </span>
                </a>

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

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- REAL-TIME NOTIFICATION SYSTEM                                  -->
    <!-- ═══════════════════════════════════════════════════════════════ -->

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-24 right-4 z-50 flex flex-col gap-3 pointer-events-none" style="max-width: 380px;"></div>

    <style>
        /* Toast notification animations */
        @keyframes toastSlideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0);    opacity: 1; }
            to   { transform: translateX(120%); opacity: 0; }
        }
        .toast-enter {
            animation: toastSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .toast-exit {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .toast-progress-bar {
            animation: toastProgress 6s linear forwards;
        }
        /* Pulse animation for new-order highlight */
        @keyframes rowHighlight {
            0%, 100% { background-color: transparent; }
            50%      { background-color: rgb(254 243 199 / 0.7); }
        }
        .row-highlight {
            animation: rowHighlight 1s ease-in-out 3;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─────────────────────────────────────────────
        // Configuration
        // ─────────────────────────────────────────────
        const POLL_INTERVAL   = 15000; // 15 seconds
        const TOAST_DURATION  = 6000;  // 6 seconds
        const CHECK_URL       = @json(route('admin.notifications.check'));
        const ORDERS_LIST_URL = @json(route('admin.orders.list'));

        let lastCheck = new Date().toISOString();
        let audioCtx  = null;

        // ─────────────────────────────────────────────
        // Request browser notification permission
        // ─────────────────────────────────────────────
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        // ─────────────────────────────────────────────
        // Notification Sound (Web Audio API)
        // ─────────────────────────────────────────────
        function playNotificationSound() {
            try {
                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }

                const now = audioCtx.currentTime;

                // First tone — high pitched "ding"
                const osc1 = audioCtx.createOscillator();
                const gain1 = audioCtx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now);
                gain1.gain.setValueAtTime(0.3, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.5);
                osc1.connect(gain1);
                gain1.connect(audioCtx.destination);
                osc1.start(now);
                osc1.stop(now + 0.5);

                // Second tone — slightly higher, short delay
                const osc2 = audioCtx.createOscillator();
                const gain2 = audioCtx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(1175, now + 0.15);
                gain2.gain.setValueAtTime(0, now);
                gain2.gain.setValueAtTime(0.25, now + 0.15);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.7);
                osc2.connect(gain2);
                gain2.connect(audioCtx.destination);
                osc2.start(now + 0.15);
                osc2.stop(now + 0.7);
            } catch (e) {
                // Audio not available, silently ignore
            }
        }

        // ─────────────────────────────────────────────
        // Toast Notification
        // ─────────────────────────────────────────────
        function showToast(order) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const typeColors = {
                'bops':     { bg: 'bg-purple-50',  border: 'border-purple-200', icon: 'text-purple-600', label: 'BOPS (Pickup)' },
                'delivery': { bg: 'bg-emerald-50', border: 'border-emerald-200', icon: 'text-emerald-600', label: 'Delivery' },
                'pos':      { bg: 'bg-blue-50',    border: 'border-blue-200', icon: 'text-blue-600', label: 'POS' },
            };
            const tc = typeColors[order.transaction_type] || typeColors['delivery'];

            const amount = new Intl.NumberFormat('id-ID').format(order.total_amount);

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto bg-white rounded-2xl shadow-2xl border ${tc.border} overflow-hidden toast-enter`;
            toast.innerHTML = `
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl ${tc.bg} ${tc.icon} flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-brand-900">Pesanan Baru!</span>
                                <button onclick="this.closest('.toast-enter, [class*=pointer-events-auto]').remove()" class="text-slate-400 hover:text-slate-600 transition-colors p-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <p class="text-sm font-bold text-brand-800 mt-1 truncate">${order.invoice_number}</p>
                            <p class="text-xs text-slate-500 mt-0.5 truncate">${order.customer_name}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${tc.bg} ${tc.icon}">${tc.label}</span>
                                <span class="text-xs font-bold text-brand-600">Rp${amount}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-slate-100">
                    <div class="h-full bg-brand-500 rounded-full toast-progress-bar"></div>
                </div>
            `;

            container.appendChild(toast);

            // Make toast clickable — navigate to orders
            toast.querySelector('.flex.items-start').style.cursor = 'pointer';
            toast.querySelector('.flex.items-start').addEventListener('click', function(e) {
                if (e.target.closest('button')) return;
                window.location.href = '/admin/orders?status=pending';
            });

            // Auto-remove after duration
            setTimeout(() => {
                toast.classList.remove('toast-enter');
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            }, TOAST_DURATION);
        }

        // ─────────────────────────────────────────────
        // Browser Notification
        // ─────────────────────────────────────────────
        function showBrowserNotification(order) {
            if ('Notification' in window && Notification.permission === 'granted') {
                try {
                    const amount = new Intl.NumberFormat('id-ID').format(order.total_amount);
                    const notif = new Notification('🔔 Pesanan Baru — Toko Nelly', {
                        body: `${order.invoice_number}\n${order.customer_name} — Rp${amount}\nTipe: ${order.transaction_type.toUpperCase()}`,
                        icon: '/images/logo.jpg',
                        tag: 'order-' + order.id,
                        requireInteraction: false,
                    });
                    notif.onclick = function() {
                        window.focus();
                        window.location.href = '/admin/orders?status=pending';
                        notif.close();
                    };
                } catch (e) {
                    // Browser notification not supported
                }
            }
        }

        // ─────────────────────────────────────────────
        // Update Badge Counters
        // ─────────────────────────────────────────────
        function updateBadges(data) {
            // Sidebar badge (Pesanan link)
            const sidebarBadge = document.getElementById('sidebar-order-badge');
            if (sidebarBadge) {
                if (data.pending_count > 0) {
                    sidebarBadge.textContent = data.pending_count;
                    sidebarBadge.style.display = '';
                } else {
                    sidebarBadge.style.display = 'none';
                }
            }

            // Header bell badge
            const headerBell = document.getElementById('header-bell-container');
            if (headerBell) {
                if (data.pending_count > 0) {
                    headerBell.style.display = '';
                    const badge = headerBell.querySelector('.notif-badge-count');
                    if (badge) badge.textContent = data.pending_count;
                } else {
                    headerBell.style.display = 'none';
                }
            }
        }

        // ─────────────────────────────────────────────
        // Update Dashboard (if on dashboard page)
        // ─────────────────────────────────────────────
        function updateDashboard(data) {
            const pendingCard = document.getElementById('dashboard-pending-count');
            if (pendingCard) {
                pendingCard.textContent = data.pending_count;
            }

            // Update notification banner
            const banner = document.getElementById('dashboard-pending-banner');
            if (banner) {
                if (data.pending_count > 0) {
                    banner.style.display = '';
                    const bannerCount = document.getElementById('dashboard-pending-banner-count');
                    if (bannerCount) bannerCount.textContent = data.pending_count + ' Pesanan Online Menunggu!';

                    const bannerDetail = document.getElementById('dashboard-pending-banner-detail');
                    if (bannerDetail) {
                        let parts = [];
                        if (data.pending_bops > 0) parts.push(`<span class="font-semibold">${data.pending_bops} BOPS (Pickup)</span>`);
                        if (data.pending_bops > 0 && data.pending_delivery > 0) parts.push(' &bull; ');
                        if (data.pending_delivery > 0) parts.push(`<span class="font-semibold">${data.pending_delivery} Delivery</span>`);
                        parts.push(' — Segera proses untuk kepuasan pelanggan.');
                        bannerDetail.innerHTML = parts.join('');
                    }
                } else {
                    banner.style.display = 'none';
                }
            }
        }

        // ─────────────────────────────────────────────
        // Refresh Order Table (if on orders page)
        // ─────────────────────────────────────────────
        function refreshOrderTable() {
            const tbody = document.getElementById('order-table-body');
            if (!tbody) return; // Not on orders page

            // Get current filter params from URL
            const params = new URLSearchParams(window.location.search);
            const url = ORDERS_LIST_URL + '?' + params.toString();

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                }
            })
            .then(res => res.text())
            .then(html => {
                tbody.innerHTML = html;
            })
            .catch(err => {
                console.warn('Order table refresh failed:', err);
            });
        }

        // ─────────────────────────────────────────────
        // Main Polling Function
        // ─────────────────────────────────────────────
        function pollNotifications() {
            const url = CHECK_URL + '?last_check=' + encodeURIComponent(lastCheck);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                // Update timestamp for next poll
                if (data.server_time) {
                    lastCheck = data.server_time;
                }

                // Update badge counters on all pages
                updateBadges(data);

                // Update dashboard if on dashboard
                updateDashboard(data);

                // If there are new orders
                if (data.new_orders && data.new_orders.length > 0) {
                    // Play sound once for all new orders
                    playNotificationSound();

                    // Show toast for each new order (max 5 to avoid overflow)
                    const ordersToShow = data.new_orders.slice(0, 5);
                    ordersToShow.forEach((order, idx) => {
                        setTimeout(() => {
                            showToast(order);
                            showBrowserNotification(order);
                        }, idx * 300); // Stagger toasts
                    });

                    // If on orders page, refresh the table
                    refreshOrderTable();
                }
            })
            .catch(err => {
                console.warn('Notification poll failed:', err);
            });
        }

        // ─────────────────────────────────────────────
        // Start Polling
        // ─────────────────────────────────────────────
        setInterval(pollNotifications, POLL_INTERVAL);

        // Also poll once immediately on page load (after a brief delay)
        setTimeout(pollNotifications, 2000);
    });
    </script>

</body>
</html>
