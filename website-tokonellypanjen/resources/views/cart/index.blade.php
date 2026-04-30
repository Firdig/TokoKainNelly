<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100">
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

    <!-- Page Title Bar -->
    <div class="bg-gradient-to-br from-brand-800 to-brand-600 pt-28 pb-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full border-[40px] border-white -translate-y-1/2 translate-x-1/3"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-extrabold text-white font-outfit">Keranjang Belanja</h1>
            <p class="text-brand-300 mt-1 text-sm">Tinjau kain pilihan Anda sebelum checkout.</p>
        </div>
    </div>

    <main class="flex-1 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
                <ul class="text-sm font-medium space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            @if(!$cart || $cart->items->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-3xl p-16 text-center border border-brand-100 shadow-sm max-w-lg mx-auto">
                    <div class="w-24 h-24 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-brand-900 mb-2 font-outfit">Keranjang Masih Kosong</h2>
                    <p class="text-slate-400 mb-8 text-sm">Tambahkan kain favorit Anda ke keranjang dari halaman katalog.</p>
                    <a href="{{ route('katalog') }}" class="btn-primary inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="lg:flex gap-8">
                    <!-- Cart Items List -->
                    <div class="flex-1 space-y-4">
                        @php $cartTotal = 0; @endphp
                        @foreach($cart->items as $item)
                        @php
                            $itemPrice = $item->productVariant->product->price;
                            $itemTotal = $item->quantity * $itemPrice;
                            $cartTotal += $itemTotal;
                        @endphp
                        <div class="bg-white rounded-2xl p-5 border border-brand-100 shadow-sm flex flex-col sm:flex-row gap-5 items-center">
                            
                            <!-- Image -->
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl bg-brand-50 flex items-center justify-center shrink-0 border border-brand-100 overflow-hidden">
                                @if($item->productVariant && $item->productVariant->image_mime)
                                    <img src="{{ route('image.variant', $item->productVariant->id) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="font-outfit font-bold text-brand-900">
                                    <a href="{{ route('product.show', $item->productVariant->product->id) }}" class="hover:text-brand-600 transition-colors">{{ $item->productVariant->product->name }}</a>
                                </h3>
                                <div class="flex items-center justify-center sm:justify-start gap-2 mt-1 mb-3">
                                    <span class="w-4 h-4 rounded-full border-2 border-white shadow-sm ring-1 ring-slate-200 shrink-0" style="background-color: {{ $item->productVariant->hex_code ?? '#ccc' }}"></span>
                                    <span class="text-sm text-slate-500">{{ $item->productVariant->color_name ?? 'Default' }}</span>
                                </div>
                                <div class="font-bold text-brand-600 text-lg">Rp{{ number_format($itemPrice, 0, ',', '.') }}<span class="text-xs text-slate-400 font-medium">/m</span></div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col items-center sm:items-end justify-between h-full gap-4">
                                <!-- Delete -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Hapus produk ini?')" class="text-xs text-red-400 hover:text-red-600 font-bold flex items-center gap-1 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>

                                <!-- Qty + Subtotal -->
                                <div class="flex flex-col items-center sm:items-end gap-2">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="cart-update-form">
                                        @csrf
                                        <div class="flex items-center bg-brand-50 border border-brand-100 rounded-lg h-9 overflow-hidden">
                                            <button type="button"
                                                class="qty-btn minus w-9 h-full flex items-center justify-center text-brand-600 hover:bg-brand-100 font-bold transition-colors border-r border-brand-100"
                                                data-step="-0.5">−</button>
                                            <input type="number" step="any" name="quantity"
                                                value="{{ $item->quantity }}"
                                                min="0.5" max="{{ $item->productVariant->stock }}"
                                                class="qty-input w-12 text-center text-sm font-bold text-brand-900 border-none focus:ring-0 p-0 outline-none bg-transparent"
                                                data-price="{{ $item->productVariant->product->price }}">
                                            <button type="button"
                                                class="qty-btn plus w-9 h-full flex items-center justify-center text-brand-600 hover:bg-brand-100 font-bold transition-colors border-l border-brand-100"
                                                data-step="0.5">+</button>
                                        </div>
                                    </form>
                                    <div class="item-subtotal font-outfit font-bold text-brand-900 text-sm">Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="w-full lg:w-80 xl:w-96 shrink-0 mt-8 lg:mt-0">
                        <div class="bg-white rounded-2xl p-7 shadow-sm border border-brand-100 sticky top-28">
                            <h3 class="font-outfit font-bold text-xl text-brand-900 mb-6 flex items-center gap-2">
                                <div class="w-7 h-7 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                Ringkasan Pesanan
                            </h3>
                            
                            <div class="space-y-3 mb-5 text-sm">
                                <div class="flex justify-between text-slate-500">
                                    <span>Subtotal Produk</span>
                                    <span id="summary-subtotal" class="font-bold text-brand-900">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Total Meter</span>
                                    <span id="summary-meters" class="font-bold text-brand-900">{{ $cart->items->sum('quantity') }} m</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-brand-100 pt-5 mb-6 flex justify-between items-center">
                                <span class="font-outfit font-bold text-brand-900">Total Bayar</span>
                                <span id="summary-total" class="font-outfit font-extrabold text-2xl text-brand-600">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="btn-primary flex items-center justify-center gap-2 w-full text-center text-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Checkout Sekarang
                            </a>
                            <a href="{{ route('katalog') }}" class="block mt-3 text-center text-sm text-brand-600 hover:text-brand-700 font-medium transition-colors">
                                ← Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 text-brand-100 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-8 w-8 rounded-lg object-cover">
                <span class="font-outfit font-bold text-lg text-white">Toko Nelly Panjen</span>
            </div>
            <p class="text-brand-500 text-sm">&copy; {{ date('Y') }} Toko Kain Nelly Panjen. All rights reserved.</p>
        </div>
    </footer>

<script>
(function () {
    // Format a number as Indonesian Rupiah string (no decimal)
    function formatRp(amount) {
        return 'Rp' + Math.round(amount).toLocaleString('id-ID');
    }

    // Recalculate all subtotals and the grand-total summary
    function recalcTotals() {
        let grandTotal = 0;
        let grandMeters = 0;

        document.querySelectorAll('.cart-update-form').forEach(function (form) {
            const input = form.querySelector('.qty-input');
            const subtotalEl = form.closest('.flex.flex-col.items-center').querySelector('.item-subtotal');
            const qty = parseFloat(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            const itemTotal = qty * price;

            if (subtotalEl) subtotalEl.textContent = formatRp(itemTotal);
            grandTotal += itemTotal;
            grandMeters += qty;
        });

        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryMeters   = document.getElementById('summary-meters');
        const summaryTotal    = document.getElementById('summary-total');

        if (summarySubtotal) summarySubtotal.textContent = formatRp(grandTotal);
        if (summaryMeters)   summaryMeters.textContent   = grandMeters.toLocaleString('id-ID') + ' m';
        if (summaryTotal)    summaryTotal.textContent     = formatRp(grandTotal);
    }

    // Debounce helper — waits `delay` ms after the last call before firing fn
    function debounce(fn, delay) {
        let timer;
        return function () {
            const ctx  = this;
            const args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () { fn.apply(ctx, args); }, delay);
        };
    }

    // Wire up every cart form
    document.querySelectorAll('.cart-update-form').forEach(function (form) {
        const input    = form.querySelector('.qty-input');
        const minusBtn = form.querySelector('.qty-btn.minus');
        const plusBtn  = form.querySelector('.qty-btn.plus');

        // Debounced submit — fires 600 ms after the last quantity change
        const submitDebounced = debounce(function () {
            form.submit();
        }, 600);

        function changeQty(delta) {
            const current = parseFloat(input.value) || 0;
            const min     = parseFloat(input.min)   || 0.5;
            const max     = parseFloat(input.max)   || Infinity;
            const next    = Math.round((current + delta) * 10) / 10; // avoid float drift

            if (next < min || next > max) return;

            input.value = next;
            recalcTotals();      // instant visual feedback
            submitDebounced();   // delayed server sync
        }

        minusBtn.addEventListener('click', function () { changeQty(-0.5); });
        plusBtn.addEventListener('click',  function () { changeQty(+0.5); });

        // Also handle manual typing in the input
        input.addEventListener('input', function () {
            recalcTotals();
            submitDebounced();
        });
    });
})();
</script>

</body>
</html>
