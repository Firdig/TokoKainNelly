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
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-8 w-8 rounded object-cover shadow-sm">
                <h1 class="font-outfit font-bold text-lg text-brand-900">Toko Kain Nelly <span class="text-brand-400 font-normal ml-2">| Point of Sale</span></h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-brand-900">Kasir Utama</p>
                    <p class="text-xs text-brand-500">{{ date('d M Y') }}</p>
                </div>
                <a href="/admin" class="px-4 py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 rounded-lg text-sm font-medium transition-colors">Dashboard Admin</a>
                <a href="/" class="px-4 py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 rounded-lg text-sm font-medium transition-colors">Ke Katalog Web</a>
            </div>
        </div>
    </nav>

    <!-- Main Workspace -->
    <div class="flex flex-1 overflow-hidden">
        
        <!-- Left Side: Product Grid -->
        <main class="flex-1 flex flex-col bg-brand-50">
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

                {{-- Filter Pills (dynamic dari fabric_type) --}}
                @php
                    $fabricTypes = $products->pluck('fabric_type')->filter()->unique()->sort()->values();
                @endphp
                @if($fabricTypes->isNotEmpty())
                <div class="flex flex-wrap gap-2" id="filterPills">
                    <button onclick="setFilter('')"
                            data-filter=""
                            class="filter-pill active px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all"
                            id="pill_semua">Semua</button>
                    @foreach($fabricTypes as $type)
                    <button onclick="setFilter('{{ addslashes($type) }}')"
                            data-filter="{{ $type }}"
                            class="filter-pill px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all"
                            id="pill_{{ Str::slug($type) }}">{{ ucfirst($type) }}</button>
                    @endforeach
                </div>
                @endif
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
                    <button onclick="clearSearchInput(); setFilter('')"
                            class="mt-4 px-4 py-2 bg-brand-50 text-brand-600 rounded-lg text-sm font-semibold hover:bg-brand-100 transition-colors">
                        Reset Pencarian
                    </button>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="productGrid">
                    @foreach($products as $product)
                        @foreach($product->variants as $variant)
                        <div class="product-card bg-white rounded-xl border border-brand-100 shadow-sm hover:shadow-md transition-all cursor-pointer group flex flex-col h-full overflow-hidden {{ $variant->stock == 0 ? 'opacity-60 grayscale' : '' }}"
                             data-name="{{ strtolower($product->name) }}"
                             data-color="{{ strtolower($variant->color_name) }}"
                             data-type="{{ strtolower($product->fabric_type ?? '') }}"
                             onclick="{{ $variant->stock > 0 ? "tambahKeKeranjang({$variant->id}, '" . addslashes($product->name . ' - ' . $variant->color_name) . "', {$product->price}, {$variant->stock})" : "alert('Stok Habis!')" }}">
                            <div class="p-4 flex-1 flex flex-col items-center text-center justify-center relative">
                                <!-- Quick add indication overlay -->
                                <div class="absolute inset-0 bg-brand-600/5 items-center justify-center hidden group-active:flex transition-opacity z-20">
                                    <svg class="w-8 h-8 text-brand-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                
                                @if($variant->image_mime)
                                    <img src="{{ route('image.variant', $variant->id) }}" class="w-16 h-16 object-cover rounded-md mb-3 shadow-sm border border-slate-100" alt="{{ $variant->color_name }}">
                                @else
                                    <div class="w-16 h-16 rounded-md mb-3 shadow-sm border border-slate-200" style="background-color: {{ $variant->hex_code ?? '#ccc' }}"></div>
                                @endif
                                
                                <h3 class="font-outfit font-bold text-brand-900 mb-1 leading-tight text-sm">{{ $product->name }}</h3>
                                <p class="text-xs text-brand-600 font-bold mb-2">{{ $variant->color_name }}</p>
                                <p class="text-brand-900 font-semibold mb-3 text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}<span class="text-[10px] font-normal text-slate-400">/m</span></p>
                                
                                <div class="mt-auto w-full pt-3 border-t border-brand-50 flex justify-between items-center text-xs relative z-10">
                                    <span class="text-slate-500 font-medium">Stok: <strong class="{{ $variant->stock < 10 ? 'text-red-500' : 'text-brand-900' }}">{{ $variant->stock }}m</strong></span>
                                    <span class="bg-brand-50 text-brand-600 px-2 py-1 rounded {{ $variant->stock == 0 ? 'hidden' : '' }} font-bold text-[10px] uppercase">+ Tambah</span>
                                    <span class="bg-red-50 text-red-600 px-2 py-1 rounded font-bold text-[10px] {{ $variant->stock > 0 ? 'hidden' : '' }}">HABIS</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Right Side: Cart / Checkout Panel -->
        <aside class="w-96 bg-white border-l border-brand-200 flex flex-col shadow-[-4px_0_15px_-3px_rgba(0,0,0,0.05)] z-20">
            <!-- Header Cart -->
            <div class="p-5 border-b border-brand-100 bg-brand-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center text-brand-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="font-outfit font-bold text-brand-900 text-lg">Keranjang Kasir</h2>
                        <p class="text-xs text-brand-500" id="itemCount">0 Item</p>
                    </div>
                </div>
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

                <!-- Metode Pembayaran -->
                <div class="px-5 pt-4 pb-3 border-b border-brand-50">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Metode Pembayaran</p>
                    <div class="grid grid-cols-3 gap-2" id="paymentOptions">
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="sr-only" checked>
                            <div class="payment-btn selected flex flex-col items-center gap-1 p-2 rounded-xl border-2 text-center transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span class="text-[10px] font-bold">Tunai</span>
                            </div>
                        </label>
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="transfer" class="sr-only">
                            <div class="payment-btn flex flex-col items-center gap-1 p-2 rounded-xl border-2 text-center transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                <span class="text-[10px] font-bold">Transfer</span>
                            </div>
                        </label>
                        <label class="payment-option cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="sr-only">
                            <div class="payment-btn flex flex-col items-center gap-1 p-2 rounded-xl border-2 text-center transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                <span class="text-[10px] font-bold">QRIS</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Total + Tombol Bayar -->
                <div class="px-5 py-4">
                    <div class="flex justify-between items-end mb-3">
                        <span class="text-slate-500 font-semibold text-sm">Total Belanja</span>
                        <span class="font-outfit font-bold text-3xl text-brand-900" id="totalHarga">Rp0</span>
                    </div>
                    <button class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-lg py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" id="btnCheckout" onclick="prosesCheckoutPOS()" disabled>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </aside>
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

    // ──────────────────────────────────────────────────
    // SEARCH & FILTER
    // ──────────────────────────────────────────────────
    let activeFilter = '';
    let debounceTimer = null;

    function debouncedFilter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(filterProducts, 200);
    }

    function setFilter(type) {
        activeFilter = type.toLowerCase();
        // Update pill styles
        document.querySelectorAll('.filter-pill').forEach(pill => {
            const isActive = pill.dataset.filter.toLowerCase() === activeFilter;
            pill.classList.toggle('active', isActive);
        });
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
            const type  = card.dataset.type  || '';

            const matchText   = !query || name.includes(query) || color.includes(query);
            const matchFilter = !activeFilter || type === activeFilter;

            if (matchText && matchFilter) {
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

    function tambahKeKeranjang(id, nama, harga, stok) {
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
        document.getElementById('totalHarga').innerText = 'Rp' + total.toLocaleString('id-ID');
        document.getElementById('itemCount').innerText = totalItems.toLocaleString('id-ID') + ' m';
    }

    function renderKeranjang() {
        const listContainer = document.getElementById('daftarKeranjang');

        if (keranjang.length === 0) {
            listContainer.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-60">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="font-medium text-sm">Belum ada barang di keranjang</p>
                </div>`;
            document.getElementById('btnCheckout').disabled = true;
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
            document.getElementById('btnCheckout').disabled = false;
        }

        updateTotal();
        listContainer.scrollTop = listContainer.scrollHeight;
    }

    // Styling radio pembayaran
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-btn').forEach(b => b.classList.remove('selected'));
            this.closest('label').querySelector('.payment-btn').classList.add('selected');
        });
    });

    function prosesCheckoutPOS() {
        if (keranjang.length === 0) return;

        const selectedPayment = document.querySelector('input[name="payment_method"]:checked')?.value || 'cash';

        let btn = document.getElementById('btnCheckout');
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> Memproses...`;

        let dataPesanan = {
            transaction_type: 'pos',
            payment_method: selectedPayment,
            items: keranjang.map(item => ({ product_variant_id: item.product_variant_id, quantity: item.quantity }))
        };

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
                // Buka struk di tab baru
                window.open('/kasir/receipt/' + data.order.id, '_blank');
                // Reset keranjang dan muat ulang halaman POS
                keranjang = [];
                location.reload();
            } else {
                // Tampilkan pesan error dari server
                alert(data.message || 'Terjadi kesalahan saat memproses transaksi.');
                btn.disabled = false;
                btn.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Bayar Sekarang`;
            }
        })
        .catch(error => {
            alert('Gagal terhubung ke server. Periksa koneksi Anda.');
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Bayar Sekarang`;
        });
    }
</script>

</body>
</html>