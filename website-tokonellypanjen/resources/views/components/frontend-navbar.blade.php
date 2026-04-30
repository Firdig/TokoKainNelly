<nav class="hidden md:flex space-x-6 items-center font-outfit font-medium text-sm">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-brand-700 font-bold' : 'text-slate-500 hover:text-brand-600 transition-colors' }}">Beranda</a>
    <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') || request()->routeIs('product.show') ? 'text-brand-700 font-bold' : 'text-slate-500 hover:text-brand-600 transition-colors' }}">Katalog Kain</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-brand-700 font-bold' : 'text-slate-500 hover:text-brand-600 transition-colors' }}">Tentang Kami</a>
    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-brand-700 font-bold' : 'text-slate-500 hover:text-brand-600 transition-colors' }}">Hubungi Kami</a>
    
    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
            <a href="{{ url('/admin/dashboard') }}" class="text-brand-600 hover:text-brand-700 font-bold flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Panel Admin
            </a>
        @endif
        
        <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 {{ request()->routeIs('cart.index') ? 'text-brand-700 font-bold' : 'text-slate-500 hover:text-brand-600 transition-colors' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span>Keranjang</span>
            @php
                $cartId = \Illuminate\Support\Facades\Session::get('cart_id');
                $cartCount = \App\Models\CartItem::whereHas('cart', function($q) use($cartId) {
                    $q->where('session_id', $cartId);
                })->count();
            @endphp
            @if($cartCount > 0)
                <span class="absolute -top-2 -right-3 bg-brand-600 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
            @endif
        </a>

        <div class="relative group ml-2 pl-4 border-l border-brand-100">
            <button class="flex items-center gap-2 text-slate-600 hover:text-brand-900 transition-colors">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-600 to-brand-400 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="text-sm font-semibold">{{ explode(' ', auth()->user()->name)[0] }}</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="absolute right-0 top-full mt-2.5 w-52 bg-white rounded-xl shadow-xl shadow-brand-900/10 border border-brand-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right group-hover:translate-y-0 translate-y-2 py-2 z-50">
                <div class="px-4 py-3 border-b border-brand-50 mb-1">
                    <div class="text-sm font-bold text-brand-900 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-800 font-medium transition-colors">Pesanan Saya</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-brand-50 pt-1">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 font-medium transition-colors rounded-b-xl">Keluar</button>
                </form>
            </div>
        </div>
    @else
        <div class="flex items-center gap-3 ml-2 pl-4 border-l border-brand-100">
            <a href="{{ route('login') }}" class="text-brand-700 font-bold hover:text-brand-900 transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-brand-600 to-brand-700 text-white rounded-xl font-bold text-sm hover:from-brand-700 hover:to-brand-800 transition-all shadow-md shadow-brand-600/25 hover:-translate-y-0.5">Daftar</a>
        </div>
    @endauth
</nav>


