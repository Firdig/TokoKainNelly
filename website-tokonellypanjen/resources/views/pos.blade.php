<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir (POS) - Toko Kain Nelly</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 h-screen overflow-hidden font-sans flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-brand-100 flex-shrink-0 z-10 shadow-sm relative">
        <div class="px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-7 w-7 sm:h-8 sm:w-8 rounded object-cover shadow-sm">
                <h1 class="font-outfit font-bold text-base sm:text-lg text-brand-900 truncate max-w-[150px] sm:max-w-none">Toko Kain Nelly <span class="text-brand-400 font-normal hidden sm:inline ml-2">| Point of Sale</span></h1>
            </div>
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-brand-900">Kasir Utama</p>
                    <p class="text-xs text-brand-500">{{ date('d M Y') }}</p>
                </div>
                <a href="/admin" class="px-3 py-1.5 sm:px-4 sm:py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 rounded-lg text-xs sm:text-sm font-medium transition-colors whitespace-nowrap">Dashboard Admin</a>
                <a href="/" class="hidden sm:inline-block px-3 py-1.5 sm:px-4 sm:py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 rounded-lg text-xs sm:text-sm font-medium transition-colors whitespace-nowrap">Ke Katalog Web</a>
            </div>
        </div>
    </nav>

    <!-- Main Workspace -->
    <div class="flex flex-1 overflow-hidden relative">
        
        <!-- Left Side: Product Grid -->
        <main class="flex-1 flex flex-col bg-brand-50 w-full overflow-hidden" id="posProductSection">
            {{-- ── Header + Search + Filter Pills ── --}}
            <div class="px-6 pt-6 pb-3 flex-shrink-0">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="font-outfit text-2xl font-bold text-brand-900">Daftar Produk</h2>
                        <p class="text-sm text-slate-500" id="produkCount">Klik produk untuk menambahkan ke keranjang.</p>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="relative mb-3">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="searchProduk"
                           placeholder="Cari nama kain atau warna... (Ctrl+K)"
                           autocomplete="off"
                           autofocus
                           oninput="debouncedFilter()"
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-brand-200 bg-white text-sm text-brand-900
                                  placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-400
                                  focus:border-transparent transition-shadow shadow-sm">
                    {{-- Clear button --}}
                    <button id="clearSearch"
                            onclick="clearSearchInput()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-300 hover:text-slate-500 hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>


            </div>

            <div class="flex-1 overflow-y-auto px-6 pb-6 custom-scrollbar">
                {{-- Empty state saat filter tidak ada hasil --}}
                <div id="emptyFilterState" class="hidden flex-col items-center justify-center py-20 text-center">
                    <svg class="w-16 h-16 text-brand-100 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <p class="text-base font-semibold text-slate-400">Produk tidak ditemukan.</p>
                    <p class="text-sm text-slate-300 mt-1">Coba kata kunci atau filter yang berbeda.</p>
                    <button onclick="clearSearchInput()"
                            class="mt-4 px-4 py-2 bg-brand-50 text-brand-600 rounded-lg text-sm font-semibold hover:bg-brand-100 transition-colors">
                        Reset Pencarian
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="productGrid">
                    @foreach($products as $product)
                        @foreach($product->variants as $variant)
                        <div id="product-card-{{ $variant->id }}" class="product-card bg-white rounded-xl border border-brand-100 shadow-sm hover:shadow-md transition-all cursor-pointer group flex flex-col h-full overflow-hidden {{ $variant->stock == 0 ? 'opacity-60 grayscale' : '' }}"
                             data-name="{{ strtolower($product->name) }}"
                             data-color="{{ strtolower($variant->color_name) }}"

                             onclick="tambahKeKeranjang({{ $variant->id }}, '{{ addslashes($product->name . ' - ' . $variant->color_name) }}', {{ $product->price }})">
                            <div class="p-4 flex-1 flex flex-col items-center text-center justify-center relative">
                                <!-- Quick add indication overlay -->
                                <div class="absolute inset-0 bg-brand-600/5 items-center justify-center hidden group-active:flex transition-opacity z-20">
                                    <svg class="w-8 h-8 text-brand-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                
                                @if($variant->image_mime)
                                    <img src="{{ route('image.variant', $variant->id) }}" loading="lazy" class="w-16 h-16 object-cover rounded-md mb-3 shadow-sm border border-slate-100" alt="{{ $variant->color_name }}">
                                @else
                                    <div class="w-16 h-16 rounded-md mb-3 shadow-sm border border-slate-200" style="background-color: {{ $variant->hex_code ?? '#ccc' }}"></div>
                                @endif
                                
                                <h3 class="font-outfit font-bold text-brand-900 mb-1 leading-tight text-sm">{{ $product->name }}</h3>
                                <p class="text-xs text-brand-600 font-bold mb-2">{{ $variant->color_name }}</p>
                                <p class="text-brand-900 font-semibold mb-3 text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}<span class="text-[10px] font-normal text-slate-400">/m</span></p>
                                
                                <div class="mt-auto w-full pt-3 border-t border-brand-50 flex justify-between items-center text-xs relative z-10">
                                    <span class="text-slate-500 font-medium">Stok: <strong id="stock-text-{{ $variant->id }}" class="{{ $variant->stock < 10 ? 'text-red-500' : 'text-brand-900' }}">{{ $variant->stock }}m</strong></span>
                                    <span id="badge-tambah-{{ $variant->id }}" class="bg-brand-50 text-brand-600 px-2 py-1 rounded {{ $variant->stock == 0 ? 'hidden' : '' }} font-bold text-[10px] uppercase">+ Tambah</span>
                                    <span id="badge-habis-{{ $variant->id }}" class="bg-red-50 text-red-600 px-2 py-1 rounded font-bold text-[10px] {{ $variant->stock > 0 ? 'hidden' : '' }}">HABIS</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Overlay for mobile cart -->
        <div id="cartOverlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden transition-opacity opacity-0" onclick="toggleCart()"></div>

        <!-- Right Side: Cart / Checkout Panel -->
        <aside id="cartSidebar" class="fixed inset-y-0 right-0 w-[90%] md:w-96 bg-white lg:border-l border-brand-200 flex flex-col shadow-[-4px_0_15px_-3px_rgba(0,0,0,0.05)] z-40 transform translate-x-full lg:translate-x-0 transition-transform duration-300 lg:static">
            <!-- Header Cart -->
            <div class="p-5 border-b border-brand-100 bg-brand-50/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center text-brand-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-outfit font-bold text-brand-900 text-lg">Keranjang Kasir</h2>
                        <p class="text-xs text-brand-500" id="itemCount">0 Item</p>
                    </div>
                </div>
                <!-- Close Button for Mobile -->
                <button onclick="toggleCart()" class="lg:hidden p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-slate-50/50" id="daftarKeranjang">
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="font-medium text-sm">Belum ada barang di keranjang</p>
                </div>
            </div>

            <!-- Footer Checkout -->
            <div class="bg-white border-t border-brand-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <!-- Total + Tombol Bayar -->
                <div class="px-5 py-4">
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-slate-500 font-semibold text-sm">Total Belanja</span>
                        <span class="font-outfit font-bold text-3xl text-brand-900" id="totalHarga">Rp0</span>
                    </div>
                    <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-lg py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" id="btnLanjutkanPembayaran" onclick="bukaModalPembayaran()" disabled>
                        Lanjutkan Pembayaran
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Floating Cart Button for Mobile -->
        <button onclick="toggleCart()" class="lg:hidden fixed bottom-6 right-6 bg-brand-600 text-white p-4 rounded-full shadow-lg shadow-brand-600/30 z-30 flex items-center justify-center hover:bg-brand-700 active:scale-95 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span id="mobileCartCountBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white shadow-sm hidden">0</span>
        </button>
    </div>

    <!-- Modal Pembayaran -->
    <div id="paymentModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 px-4">
        <div class="bg-slate-50 rounded-2xl shadow-xl w-full max-w-md md:max-w-xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="paymentModalContent">
            <div class="px-5 py-4 border-b border-brand-100 flex justify-between items-center bg-white shadow-sm flex-shrink-0 z-10">
                <h2 class="font-outfit text-xl font-bold text-brand-900">Pembayaran</h2>
                <button onclick="tutupModalPembayaran()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 md:p-5 custom-scrollbar">
                <div class="max-w-2xl mx-auto">
                    <!-- Total Tagihan -->
                    <div class="bg-white p-4 md:p-5 rounded-2xl mb-6 flex justify-between items-center border border-slate-200 shadow-sm">
                        <span class="text-slate-500 font-bold uppercase tracking-widest text-xs md:text-sm">Total Tagihan</span>
                        <span class="font-outfit font-bold text-3xl md:text-4xl text-brand-900" id="paymentViewTotal">Rp0</span>
                    </div>

                    <!-- Metode Pembayaran -->
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Metode Pembayaran</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 md:gap-3 mb-6" id="paymentOptions">
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="sr-only" checked>
                            <div class="payment-btn selected flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 text-center transition-all h-full justify-center bg-white shadow-sm">
                                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span class="text-xs font-bold mt-0.5">Tunai</span>
                            </div>
                        </label>
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="edc_bca" class="sr-only">
                            <div class="payment-btn flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 text-center transition-all h-full justify-center bg-white shadow-sm">
                                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <span class="text-xs font-bold mt-0.5">EDC BCA</span>
                            </div>
                        </label>
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="edc_bni" class="sr-only">
                            <div class="payment-btn flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 text-center transition-all h-full justify-center bg-white shadow-sm">
                                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <span class="text-xs font-bold mt-0.5">EDC BNI</span>
                            </div>
                        </label>
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="sr-only">
                            <div class="payment-btn flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 text-center transition-all h-full justify-center bg-white shadow-sm">
                                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                <span class="text-xs font-bold mt-0.5">QRIS</span>
                            </div>
                        </label>
                    </div>

                    <!-- Cash Input Section -->
                    <div class="mb-6 bg-white p-4 md:p-5 rounded-2xl border border-slate-200 shadow-sm" id="cashSection">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Uang Diterima (Rp)</label>
                        <div class="relative mb-4">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold text-lg">Rp</span>
                            </div>
                            <input type="number" id="amountPaid" placeholder="0" 
                                   oninput="calculateChange()"
                                   class="w-full pl-10 pr-3 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-400 focus:border-brand-400 text-xl shadow-inner bg-slate-50 font-bold text-brand-900 transition-colors"
                                   min="0">
                        </div>
                        
                        <!-- Virtual Numpad -->
                        <div class="grid grid-cols-4 gap-1.5 md:gap-2 mb-4" id="virtualNumpad">
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('1')">1</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('2')">2</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('3')">3</button>
                            <button type="button" class="p-2 md:p-3 bg-indigo-50 hover:bg-indigo-100 active:bg-indigo-200 rounded-xl font-bold text-sm md:text-base text-indigo-700 transition-colors shadow-sm" onclick="addQuickAmount(50000)">+50K</button>
                            
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('4')">4</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('5')">5</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('6')">6</button>
                            <button type="button" class="p-2 md:p-3 bg-indigo-50 hover:bg-indigo-100 active:bg-indigo-200 rounded-xl font-bold text-sm md:text-base text-indigo-700 transition-colors shadow-sm" onclick="addQuickAmount(100000)">+100K</button>
                            
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('7')">7</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('8')">8</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('9')">9</button>
                            <button type="button" class="p-2 md:p-3 bg-red-50 hover:bg-red-100 active:bg-red-200 rounded-xl font-bold text-sm md:text-base text-red-600 transition-colors shadow-sm" onclick="clearNumpad()">C</button>
                            
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('00')">00</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('0')">0</button>
                            <button type="button" class="p-2 md:p-3 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 rounded-xl font-bold text-lg md:text-xl text-slate-800 transition-colors shadow-sm" onclick="appendNumpad('000')">000</button>
                            <button type="button" class="p-2 md:p-3 bg-brand-50 hover:bg-brand-100 active:bg-brand-200 rounded-xl flex items-center justify-center text-brand-600 transition-colors shadow-sm" onclick="backspaceNumpad()">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path></svg>
                            </button>

                            <button type="button" class="col-span-4 p-2.5 md:p-3 bg-emerald-50 hover:bg-emerald-100 active:bg-emerald-200 rounded-xl font-bold text-sm md:text-base text-emerald-700 transition-colors shadow-sm border border-emerald-200" onclick="setExactAmount()">Uang Pas (Sesuai Tagihan)</button>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-slate-500 font-bold uppercase tracking-wider text-xs">Kembalian</span>
                            <span class="font-outfit font-bold text-2xl md:text-3xl text-emerald-500" id="changeAmount">Rp0</span>
                        </div>
                    </div>

                    <!-- Nomor Referensi Pembayaran -->
                    <div class="mb-6 bg-white p-4 md:p-5 rounded-2xl border border-slate-200 shadow-sm" id="refSection" style="display:none;">
                        <label class="block text-xs font-bold text-slate-700 mb-2">No. Referensi / Approval Code <span class="text-slate-400 font-normal ml-1">(opsional)</span></label>
                        <input type="text" id="paymentRef" placeholder="Masukkan nomor referensi dari struk EDC / QRIS..."
                               class="w-full rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-400 text-sm py-3 px-4 bg-slate-50 shadow-inner">
                        <div id="refWarning" class="hidden mt-3 flex items-start gap-2 text-amber-700 text-xs font-medium bg-amber-50 p-3 rounded-xl border border-amber-200">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            <span class="leading-snug">Disarankan mengisi no. referensi untuk memudahkan rekonsiliasi data dengan laporan bank.</span>
                        </div>
                    </div>

                    <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-lg py-3.5 rounded-2xl shadow-[0_8px_20px_-6px_rgba(30,58,95,0.4)] transition-all flex justify-center items-center gap-2 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none mb-6" id="btnCheckout" onclick="prosesCheckoutPOS()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Konfirmasi & Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Ref Modal -->
    <div id="confirmRefModal" class="fixed inset-0 bg-slate-900/60 z-[60] hidden flex items-center justify-center opacity-0 transition-opacity duration-300 px-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300" id="confirmRefContent">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">No. Referensi Kosong</h3>
                <p class="text-slate-500 text-sm mb-6">Anda belum memasukkan nomor referensi pembayaran. Apakah Anda yakin ingin melanjutkan tanpa nomor referensi?</p>
                <div class="flex gap-3">
                    <button type="button" onclick="cancelCheckoutWithRef()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl transition-colors">Batal</button>
                    <button type="button" onclick="proceedCheckoutWithoutRef()" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-xl transition-colors shadow-sm">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>



<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Filter pills */
    .filter-pill {
        background: white;
        color: #64748b;
        border-color: #e2e8f0;
    }
    .filter-pill:hover {
        background: #f0f4ff;
        color: #1e3a5f;
        border-color: #bfcfee;
    }
    .filter-pill.active {
        background: #1e3a5f;
        color: white;
        border-color: #1e3a5f;
    }

    /* Payment method buttons */
    .payment-btn {
        border-color: #e2e8f0;
        color: #64748b;
        background: #f8fafc;
    }
    .payment-btn:hover {
        border-color: #93c5fd;
        color: #1e3a5f;
        background: #f0f4ff;
    }
    .payment-btn.selected {
        border-color: #1e3a5f;
        color: #1e3a5f;
        background: #eef2ff;
    }

    /* Qty input di keranjang */
    .qty-input {
        width: 52px;
        text-align: center;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #1e3a5f;
        padding: 2px 4px;
        outline: none;
        background: white;
    }
    .qty-input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 2px #bfdbfe55;
    }
    /* Sembunyikan spin arrows */
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .qty-input[type=number] { -moz-appearance: textfield; }
</style>

<script>
    let keranjang = [];
    let currentTotalValue = 0;
    
    const stockData = {
        @foreach($products as $product)
            @foreach($product->variants as $variant)
                {{ $variant->id }}: {{ $variant->stock }},
            @endforeach
        @endforeach
    };

    // Live stock update every 10 seconds
    function fetchStockUpdates() {
        fetch('{{ route('pos.stock') }}')
            .then(res => res.json())
            .then(data => {
                data.forEach(variant => {
                    let id = variant.id;
                    let stock = parseFloat(variant.stock);
                    
                    // Update global stock data
                    stockData[id] = stock;
                    
                    // Update DOM
                    let card = document.getElementById('product-card-' + id);
                    if (card) {
                        let stockText = document.getElementById('stock-text-' + id);
                        let badgeTambah = document.getElementById('badge-tambah-' + id);
                        let badgeHabis = document.getElementById('badge-habis-' + id);
                        
                        if (stockText) {
                            stockText.innerText = stock + 'm';
                            if (stock < 10) {
                                stockText.classList.remove('text-brand-900');
                                stockText.classList.add('text-red-500');
                            } else {
                                stockText.classList.remove('text-red-500');
                                stockText.classList.add('text-brand-900');
                            }
                        }

                        if (stock <= 0) {
                            card.classList.add('opacity-60', 'grayscale');
                            if (badgeTambah) badgeTambah.classList.add('hidden');
                            if (badgeHabis) badgeHabis.classList.remove('hidden');
                        } else {
                            card.classList.remove('opacity-60', 'grayscale');
                            if (badgeTambah) badgeTambah.classList.remove('hidden');
                            if (badgeHabis) badgeHabis.classList.add('hidden');
                        }
                    }
                    
                    // Update stock in keranjang if exists
                    let item = keranjang.find(i => i.product_variant_id === id);
                    if (item) {
                        item.stock = stock;
                    }
                });
                renderKeranjang();
            })
            .catch(err => console.error('Error fetching stock updates:', err));
    }
    
    // Call every 10 seconds
    setInterval(fetchStockUpdates, 10000);

    // ──────────────────────────────────────────────────
    // SEARCH & FILTER
    // ──────────────────────────────────────────────────
    let activeFilter = '';
    let debounceTimer = null;

    function debouncedFilter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterProducts, 200);
    }

    function setFilter() {
        filterProducts();
    }

    function filterProducts() {
        const query   = (document.getElementById('searchProduk')?.value || '').toLowerCase().trim();
        const cards   = document.querySelectorAll('.product-card');
        const clearBtn = document.getElementById('clearSearch');
        let visible   = 0;

        // Tampilkan/sembunyikan tombol clear
        if (clearBtn) clearBtn.classList.toggle('hidden', query.length === 0);

        cards.forEach(card => {
            const name  = card.dataset.name  || '';
            const color = card.dataset.color || '';
            const matchText   = !query || name.includes(query) || color.includes(query);

            if (matchText) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        // Empty state
        const emptyEl   = document.getElementById('emptyFilterState');
        const gridEl    = document.getElementById('productGrid');
        const countEl   = document.getElementById('produkCount');

        if (emptyEl) {
            if (visible === 0) {
                emptyEl.classList.remove('hidden');
                emptyEl.classList.add('flex');
                if (gridEl) gridEl.classList.add('hidden');
            } else {
                emptyEl.classList.add('hidden');
                emptyEl.classList.remove('flex');
                if (gridEl) gridEl.classList.remove('hidden');
            }
        }

        if (countEl) {
            countEl.textContent = visible === {{ $products->sum(fn($p) => $p->variants->count()) }}
                ? 'Klik produk untuk menambahkan ke keranjang.'
                : `Menampilkan ${visible} varian`;
        }
    }

    function clearSearchInput() {
        const input = document.getElementById('searchProduk');
        if (input) { input.value = ''; input.focus(); }
        filterProducts();
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+K atau F3 → fokus ke search
        if ((e.ctrlKey && e.key === 'k') || e.key === 'F3') {
            e.preventDefault();
            document.getElementById('searchProduk')?.focus();
        }
        // Escape → clear search (jika sedang di search bar)
        if (e.key === 'Escape') {
            const input = document.getElementById('searchProduk');
            if (document.activeElement === input && input?.value) {
                clearSearchInput();
            } else if (document.activeElement === input) {
                input?.blur();
            }
        }
    });

    function tambahKeKeranjang(id, nama, harga) {
        let stok = stockData[id];
        if (stok <= 0) {
            alert('Stok Habis!');
            return;
        }

        let itemIndex = keranjang.findIndex(item => item.product_variant_id === id);
        
        if (itemIndex > -1) {
            if (keranjang[itemIndex].quantity + 0.5 <= stok) {
                keranjang[itemIndex].quantity += 0.5;
            } else { alert('Stok tidak mencukupi!'); return; }
        } else {
            if (stok >= 0.5) keranjang.push({ product_variant_id: id, name: nama, price: harga, quantity: 1, stock: stok });
            else { alert('Stok tidak cukup untuk pembelian minimal (0.5m).'); return; }
        }
        renderKeranjang();
    }

    function kurangItem(index) {
        if(keranjang[index].quantity > 0.5) {
            keranjang[index].quantity -= 0.5;
        } else {
            hapusItem(index); return;
        }
        renderKeranjang();
    }
    
    function tambahItemQuantity(index) {
        if(keranjang[index].quantity + 0.5 <= keranjang[index].stock) {
            keranjang[index].quantity += 0.5;
            renderKeranjang();
        } else {
            alert('Maksimal stok tercapai!');
        }
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    /**
     * Set qty dari input langsung — validasi min 0.5, max stok.
     * Tidak re-render seluruh list, hanya update subtotal baris itu.
     */
    function setQty(index, value) {
        let val = parseFloat(value);
        if (isNaN(val) || val < 0.5) val = 0.5;
        if (val > keranjang[index].stock) {
            val = keranjang[index].stock;
            const inp = document.getElementById('qty_' + index);
            if (inp) inp.value = val;
        }
        // Bulatkan ke kelipatan 0.5
        val = Math.round(val * 2) / 2;
        keranjang[index].quantity = val;

        // Update subtotal baris tanpa re-render
        const subtotal = keranjang[index].price * val;
        const subtotalEl = document.getElementById('subtotal_' + index);
        if (subtotalEl) subtotalEl.textContent = 'Rp' + subtotal.toLocaleString('id-ID');

        // Recalc total
        updateTotal();
    }

    function kurangItem(index) {
        const cur = keranjang[index].quantity;
        if (cur - 0.5 < 0.5) { hapusItem(index); return; }
        keranjang[index].quantity = Math.round((cur - 0.5) * 2) / 2;
        const inp = document.getElementById('qty_' + index);
        if (inp) inp.value = keranjang[index].quantity;
        const subtotal = keranjang[index].price * keranjang[index].quantity;
        const subtotalEl = document.getElementById('subtotal_' + index);
        if (subtotalEl) subtotalEl.textContent = 'Rp' + subtotal.toLocaleString('id-ID');
        updateTotal();
    }

    function tambahItemQuantity(index) {
        const cur = keranjang[index].quantity;
        if (cur + 0.5 > keranjang[index].stock) { return; }
        keranjang[index].quantity = Math.round((cur + 0.5) * 2) / 2;
        const inp = document.getElementById('qty_' + index);
        if (inp) inp.value = keranjang[index].quantity;
        const subtotal = keranjang[index].price * keranjang[index].quantity;
        const subtotalEl = document.getElementById('subtotal_' + index);
        if (subtotalEl) subtotalEl.textContent = 'Rp' + subtotal.toLocaleString('id-ID');
        updateTotal();
    }

    function updateTotal() {
        let total = 0; let totalItems = 0;
        keranjang.forEach(item => { total += item.price * item.quantity; totalItems += item.quantity; });
        currentTotalValue = total;
        
        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
        document.getElementById('itemCount').innerText = totalItems.toLocaleString('id-ID') + ' m';
        
        // Update payment section total if it's open
        const paymentViewTotal = document.getElementById('paymentViewTotal');
        if (paymentViewTotal) {
            paymentViewTotal.innerText = 'Rp' + total.toLocaleString('id-ID');
            calculateChange();
        }

        // Update badge mobile
        const badge = document.getElementById('mobileCartCountBadge');
        if (badge) {
            if (keranjang.length > 0) {
                badge.innerText = keranjang.length;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    function renderKeranjang() {
        const listContainer = document.getElementById('daftarKeranjang');

        if (keranjang.length === 0) {
            listContainer.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="font-medium text-sm">Belum ada barang di keranjang</p>
                </div>`;
            document.getElementById('btnLanjutkanPembayaran').disabled = true;
        } else {
            let listHTML = '<div class="space-y-3">';
            keranjang.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                listHTML += `
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-brand-100 flex flex-col" id="cartrow_${index}">
                        <div class="flex justify-between items-start mb-1.5">
                            <h6 class="font-bold text-brand-900 text-sm pe-2 leading-tight">${item.name}</h6>
                            <button onclick="hapusItem(${index})" class="flex-shrink-0 text-red-400 hover:text-red-600 p-0.5 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="text-brand-500 text-xs mb-2">Rp${item.price.toLocaleString('id-ID')}<span class="text-slate-400">/m</span></div>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-2 gap-2">
                            <div class="flex items-center gap-1">
                                <button onclick="kurangItem(${index})" class="w-7 h-7 flex items-center justify-center rounded-lg bg-brand-50 text-brand-600 hover:bg-brand-200 font-bold text-base leading-none">&#8722;</button>
                                <input id="qty_${index}" type="number" value="${item.quantity}" min="0.5" max="${item.stock}" step="0.5"
                                       class="qty-input"
                                       onchange="setQty(${index}, this.value)"
                                       onclick="this.select()">
                                <button onclick="tambahItemQuantity(${index})" class="w-7 h-7 flex items-center justify-center rounded-lg bg-brand-50 text-brand-600 hover:bg-brand-200 font-bold text-base leading-none">&#43;</button>
                                <span class="text-xs font-semibold text-slate-400">m</span>
                            </div>
                            <span class="font-bold text-brand-900 text-sm" id="subtotal_${index}">Rp${subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>`;
            });
            listHTML += '</div>';
            listContainer.innerHTML = listHTML;
            document.getElementById('btnLanjutkanPembayaran').disabled = false;
        }

        updateTotal();
        listContainer.scrollTop = listContainer.scrollHeight;
    }

    // Styling radio pembayaran + toggle referensi field
    const refSection = document.getElementById('refSection');
    const cashSection = document.getElementById('cashSection');
    const refInput = document.getElementById('paymentRef');
    const refWarning = document.getElementById('refWarning');
    const methodsNeedingRef = ['edc_bca', 'edc_bni', 'qris'];

    function updateRefVisibility() {
        const selected = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';
        if (methodsNeedingRef.includes(selected)) {
            refSection.style.display = 'block';
            cashSection.style.display = 'none';
        } else {
            refSection.style.display = 'none';
            cashSection.style.display = 'block';
            if (refInput) refInput.value = '';
            if (refWarning) refWarning.classList.add('hidden');
        }
        validateCheckoutBtn();
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-btn').forEach(b => b.classList.remove('selected'));
            this.closest('label').querySelector('.payment-btn').classList.add('selected');
            updateRefVisibility();
        });
    });

    // Mobile Cart Toggle
    function toggleCart() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        
        if (sidebar.classList.contains('translate-x-full')) {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        } else {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    }

    function calculateChange() {
        const amountPaidInput = document.getElementById('amountPaid').value;
        const amountPaid = parseFloat(amountPaidInput) || 0;
        let change = amountPaid - currentTotalValue;
        if (change < 0) change = 0;
        
        document.getElementById('changeAmount').innerText = 'Rp' + change.toLocaleString('id-ID');
        validateCheckoutBtn();
    }

    function validateCheckoutBtn() {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';
        const btn = document.getElementById('btnCheckout');
        
        if (selectedPayment === 'cash') {
            const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
            if (amountPaid < currentTotalValue && currentTotalValue > 0) {
                btn.disabled = true;
                return;
            }
        }
        btn.disabled = false;
    }

    function bukaModalPembayaran() {
        if (keranjang.length === 0) return;
        
        // Update total
        document.getElementById('paymentViewTotal').innerText = 'Rp' + currentTotalValue.toLocaleString('id-ID');
        
        const modal = document.getElementById('paymentModal');
        const content = document.getElementById('paymentModalContent');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
        
        // Focus cash input
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';
        if (selectedPayment === 'cash') {
            document.getElementById('amountPaid').value = currentTotalValue; // auto fill exact amount
            calculateChange();
            setTimeout(() => {
                const input = document.getElementById('amountPaid');
                input.focus();
                input.select();
            }, 100);
        }
    }

    function tutupModalPembayaran() {
        const modal = document.getElementById('paymentModal');
        const content = document.getElementById('paymentModalContent');
        
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // Numpad Functions
    function appendNumpad(val) {
        const input = document.getElementById('amountPaid');
        if (input.value === '0') input.value = val;
        else input.value += val;
        calculateChange();
    }
    
    function addQuickAmount(amount) {
        const input = document.getElementById('amountPaid');
        let current = parseFloat(input.value) || 0;
        input.value = current + amount;
        calculateChange();
    }
    
    function clearNumpad() {
        const input = document.getElementById('amountPaid');
        input.value = '';
        calculateChange();
    }
    
    function backspaceNumpad() {
        const input = document.getElementById('amountPaid');
        input.value = input.value.slice(0, -1);
        calculateChange();
    }
    
    function setExactAmount() {
        const input = document.getElementById('amountPaid');
        input.value = currentTotalValue;
        calculateChange();
    }

    function cancelCheckoutWithRef() {
        const modal = document.getElementById('confirmRefModal');
        const content = document.getElementById('confirmRefContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
        
        refInput?.focus();
    }
    
    function proceedCheckoutWithoutRef() {
        cancelCheckoutWithRef();
        prosesCheckoutPOS(true);
    }

    function prosesCheckoutPOS(forceProceed = false) {
        if (keranjang.length === 0) return;

        const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';
        const paymentRef = (refInput?.value || '').trim();

        // Peringatan visual jika no referensi kosong untuk EDC/QRIS
        if (!forceProceed && methodsNeedingRef.includes(selectedPayment) && !paymentRef) {
            refWarning.classList.remove('hidden');
            
            // Show custom confirm modal
            const modal = document.getElementById('confirmRefModal');
            const content = document.getElementById('confirmRefContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
            return;
        }

        let btn = document.getElementById('btnCheckout');
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> Memproses...`;

        let dataPesanan = {
            transaction_type: 'pos',
            payment_method: selectedPayment,
            payment_reference: paymentRef || null,
            items: keranjang.map(item => ({ product_variant_id: item.product_variant_id, quantity: item.quantity }))
        };

        if (selectedPayment === 'cash') {
            const amountPaid = parseFloat(document.getElementById('amountPaid').value) || 0;
            let change = amountPaid - currentTotalValue;
            if (change < 0) change = 0;
            
            dataPesanan.amount_paid = amountPaid;
            dataPesanan.change_amount = change;
        }

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(dataPesanan)
        })
        .then(response => response.json())
        .then(data => {
            if (data.order && data.order.id) {
                // Pindah ke halaman struk
                window.location.href = '/kasir/receipt/' + data.order.id;
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses transaksi.');
                btn.disabled = false;
                btn.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Konfirmasi Bayar`;
            }
        })
        .catch(error => {
            alert('Gagal terhubung ke server. Periksa koneksi Anda.');
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Konfirmasi Bayar`;
        });
    }
</script>

</body>
</html>