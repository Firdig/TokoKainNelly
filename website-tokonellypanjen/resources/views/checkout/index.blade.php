<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-12 rounded-xl object-cover shadow-lg shadow-brand-600/20 ring-1 ring-brand-200/50">
                    <span class="font-outfit font-bold text-2xl text-brand-900 tracking-tight">Checkout Aman</span>
                </a>
                <a href="{{ route('cart.index') }}" class="text-slate-500 hover:text-brand-900 text-sm font-bold transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="md:flex gap-8">
                    
                    <!-- Checkout Details Form -->
                    <div class="flex-1 space-y-8">
                        
                        <!-- Section 1: Customer Info -->
                        <div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-brand-50">
                            <h2 class="text-xl font-bold font-outfit text-brand-900 mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm">1</span>
                                Informasi Pemesan
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-brand-900 mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm"
                                        placeholder="Masukkan nama lengkap" required>
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-brand-900 mb-2">Nomor Telepon <span class="text-red-400">*</span></label>
                                    <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm"
                                        placeholder="08xxxxxxxxxx" required>
                                    @error('customer_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Delivery Method -->
                        <div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-brand-50">
                            <h2 class="text-xl font-bold font-outfit text-brand-900 mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm">2</span>
                                Metode Pengambilan / Pengiriman
                            </h2>

                            @error('transaction_type')
                                <div class="mb-4 text-sm text-red-500 bg-red-50 p-3 rounded-lg">{{ $message }}</div>
                            @enderror

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="cursor-pointer" onclick="toggleDeliveryAddress('delivery')">
                                    <input type="radio" name="transaction_type" value="delivery" class="peer sr-only" required {{ old('transaction_type') === 'delivery' ? 'checked' : '' }}>
                                    <div class="p-6 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50 hover:bg-slate-50 transition-all h-full">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                            </div>
                                        </div>
                                        <h3 class="font-bold text-brand-900 mb-1">Kurir (Delivery)</h3>
                                        <p class="text-sm text-slate-500 line-clamp-2">Kain akan dikirim langsung ke alamat rumah Anda menggunakan ekspedisi terpercaya.</p>
                                    </div>
                                </label>

                                <label class="cursor-pointer" onclick="toggleDeliveryAddress('bops')">
                                    <input type="radio" name="transaction_type" value="bops" class="peer sr-only" {{ old('transaction_type') === 'bops' ? 'checked' : '' }}>
                                    <div class="p-6 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50 hover:bg-slate-50 transition-all h-full">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            </div>
                                        </div>
                                        <h3 class="font-bold text-brand-900 mb-1">Ambil Di Toko (BOPS)</h3>
                                        <p class="text-sm text-slate-500 line-clamp-2">Pesan sekarang, bayar, dan ambil kain saat sudah disiapkan oleh admin.</p>
                                    </div>
                                </label>
                            </div>

                            <!-- Delivery Address + Biteship Shipping (shown only for Delivery) -->
                            <div id="deliveryAddressSection" class="mt-6 space-y-5 {{ old('transaction_type') !== 'delivery' ? 'hidden' : '' }}">
                                <!-- Map Picker for delivery location -->
                                <div>
                                    <label class="block text-sm font-bold text-brand-900 mb-2">Tandai Lokasi Pengiriman di Peta <span class="text-red-400">*</span></label>
                                    <div class="flex items-center gap-2 mb-2">
                                        <button type="button" onclick="useMyLocation()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Gunakan Lokasi Saya
                                        </button>
                                        <span id="gpsStatus" class="text-xs text-slate-400"></span>
                                    </div>
                                    <div id="checkoutMap" class="w-full h-56 rounded-xl border border-slate-200 overflow-hidden z-0"></div>
                                    <p class="text-xs text-slate-400 mt-1">Klik peta atau geser pin untuk menandai lokasi tujuan pengiriman</p>
                                    <input type="hidden" id="destinationLat">
                                    <input type="hidden" id="destinationLng">
                                    <input type="hidden" name="destination_area_id" id="destinationAreaId" value="GPS">
                                </div>

                                <!-- Detailed Address -->
                                <div>
                                    <label class="block text-sm font-bold text-brand-900 mb-2">Detail Alamat Pengiriman <span class="text-red-400">*</span></label>
                                    <textarea name="delivery_address" rows="2" id="deliveryAddressInput"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm"
                                        placeholder="Nama jalan, no. rumah, RT/RW, patokan, dll.">{{ old('delivery_address', auth()->user()->address ?? '') }}</textarea>
                                    @error('delivery_address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Courier Selection -->
                                <div id="courierSection" class="hidden">
                                    <label class="block text-sm font-bold text-brand-900 mb-3">Pilih Kurir Pengiriman <span class="text-red-400">*</span></label>
                                    <div id="courierList" class="space-y-3"></div>
                                    <div id="courierError" class="hidden text-sm text-red-500 bg-red-50 p-3 rounded-lg mt-2"></div>
                                </div>

                                <!-- Hidden shipping fields -->
                                <input type="hidden" name="shipping_cost" id="shippingCostInput">
                                <input type="hidden" name="shipping_courier_code" id="shippingCourierCode">
                                <input type="hidden" name="shipping_courier_service" id="shippingCourierService">
                                <input type="hidden" name="shipping_courier_name" id="shippingCourierName">
                                <input type="hidden" name="shipping_etd" id="shippingEtd">
                            </div>

                            <!-- BOPS Info (shown only for BOPS) -->
                            <div id="bopsInfoSection" class="mt-6 {{ old('transaction_type') !== 'bops' ? 'hidden' : '' }}">
                                <div class="bg-gradient-to-br from-purple-50 to-brand-50 rounded-2xl p-6 border border-purple-100">
                                    <h4 class="font-bold text-brand-900 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Informasi Pengambilan di Toko
                                    </h4>
                                    <ul class="space-y-2 text-sm text-slate-600">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Estimasi kain siap dalam <strong class="text-brand-900">± 2 jam</strong> setelah pemesanan</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Anda akan menerima <strong class="text-brand-900">kode pengambilan</strong> setelah checkout</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Lokasi: <strong class="text-brand-900">Toko Kain Nelly, Pasar Panjen</strong></span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Tunjukkan kode pengambilan kepada kasir saat tiba</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Payment Method -->
                        <div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-brand-50">
                            <h2 class="text-xl font-bold font-outfit text-brand-900 mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-sm">3</span>
                                Metode Pembayaran
                            </h2>

                            @error('payment_method')
                                <div class="mb-4 text-sm text-red-500 bg-red-50 p-3 rounded-lg">{{ $message }}</div>
                            @enderror

                            <div class="space-y-4">
                                <!-- Midtrans Online Payment -->
                                <label class="block cursor-pointer group">
                                    <input type="radio" name="payment_method" value="midtrans" class="peer sr-only" required {{ old('payment_method', 'midtrans') === 'midtrans' ? 'checked' : '' }}>
                                    <div class="p-5 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/50 hover:bg-slate-50 transition-all">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-brand-900">Bayar Online</h3>
                                                    <p class="text-xs text-slate-500">Pembayaran otomatis & aman via Midtrans</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100">Direkomendasikan</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2 ml-13">
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">Transfer Bank</span>
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">QRIS</span>
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">GoPay</span>
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">ShopeePay</span>
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">OVO</span>
                                            <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">Dana</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- COD / Bayar di Tempat -->
                                <label id="payment-cod-label" class="block cursor-pointer group">
                                    <input type="radio" name="payment_method" value="cod" id="payment-cod-radio" class="peer sr-only" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                    <div class="p-5 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/50 hover:bg-slate-50 transition-all">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-brand-900">Bayar di Tempat (COD)</h3>
                                                <p class="text-xs text-slate-500">Bayar tunai saat kain diterima / diambil di toko</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Order Summary Sticky -->
                    <div class="w-full md:w-80 lg:w-96 shrink-0 mt-8 md:mt-0">
                        <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-brand-100 sticky top-32">
                            <h3 class="font-outfit font-bold text-xl text-brand-900 mb-6">Detail Pesanan Anda</h3>
                            
                            @php $cartTotal = 0; @endphp
                            <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($cart->items as $item)
                                @php 
                                    $product = $item->productVariant->product;
                                    $itemTotal = $item->quantity * $product->price;
                                    $cartTotal += $itemTotal;
                                @endphp
                                <div class="flex justify-between items-start text-sm border-b border-brand-50 pb-4 last:border-0 last:pb-0">
                                    <div class="pr-4">
                                        <div class="font-bold text-brand-900">{{ $product->name }}</div>
                                        <div class="text-xs text-brand-600 font-bold mb-1">{{ $item->productVariant->color_name ?? 'Default' }}</div>
                                        <div class="text-slate-500">{{ $item->quantity }} m x Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="font-bold text-brand-600 pt-1 shrink-0">Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                                </div>
                                @endforeach
                            </div>

                            <div class="border-t border-brand-100 pt-6 mb-8">
                                <div class="flex justify-between items-center text-sm text-slate-600 mb-2">
                                    <span>Subtotal Produk</span>
                                    <span class="font-bold text-brand-900" id="subtotalDisplay">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                                <div id="shippingCostRow" class="flex justify-between items-center text-sm text-slate-600 mb-2 hidden">
                                    <span>Ongkos Kirim</span>
                                    <span class="font-bold text-blue-600" id="shippingCostDisplay">Rp0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-slate-600 mb-4">
                                    <span>Biaya Layanan</span>
                                    <span class="font-bold text-brand-900">Gratis</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="font-bold text-brand-900 text-lg">Total</span>
                                    <span class="font-extrabold text-brand-600 font-outfit text-3xl" id="totalDisplay">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full text-center px-8 py-4 bg-brand-900 text-white rounded-xl font-bold font-outfit text-lg shadow-xl shadow-brand-900/30 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Proses Pesanan
                            </button>
                            <p class="text-center text-xs text-slate-400 mt-4 leading-relaxed">Dengan memproses pesanan, Anda menyetujui Syarat dan Ketentuan Toko Nelly.</p>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </main>

<script>
    const CART_SUBTOTAL = {{ $cartTotal }};
    const CSRF_TOKEN = '{{ csrf_token() }}';
    let selectedShippingCost = 0;
    let checkoutMap = null;
    let checkoutMarker = null;

    // Store origin (Toko Kain Nelly, Pasar Panjen, Kepanjen)
    const ORIGIN_LAT = -8.127537053688105;
    const ORIGIN_LNG = 112.57082021771222;

    // ── Haversine distance calculation (km) ──
    function getDistanceKm(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    // ── Estimate courier price based on distance ──
    function estimatePrice(distanceKm, courier) {
        // Approximate Gojek/Grab GoSend pricing (base + per km)
        const minFare = 10000;
        if (courier === 'gojek') {
            return Math.max(minFare, Math.round((8000 + distanceKm * 2500) / 1000) * 1000);
        } else {
            return Math.max(minFare, Math.round((7000 + distanceKm * 2700) / 1000) * 1000);
        }
    }

    // ── Map Initialization ──
    function initCheckoutMap() {
        if (checkoutMap) { checkoutMap.invalidateSize(); return; }
        checkoutMap = L.map('checkoutMap').setView([ORIGIN_LAT, ORIGIN_LNG], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19,
        }).addTo(checkoutMap);

        // Store marker (fixed)
        L.marker([ORIGIN_LAT, ORIGIN_LNG], {
            icon: L.divIcon({
                className: '',
                html: '<div style="background:#7c3aed;color:white;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:14px;box-shadow:0 2px 6px rgba(0,0,0,0.3);">🏪</div>',
                iconSize: [28, 28],
                iconAnchor: [14, 14],
            })
        }).addTo(checkoutMap).bindPopup('Toko Kain Nelly');

        // Destination marker (draggable)
        checkoutMarker = L.marker([ORIGIN_LAT, ORIGIN_LNG], { draggable: true }).addTo(checkoutMap);

        checkoutMap.on('click', function(e) {
            checkoutMarker.setLatLng(e.latlng);
            onDestinationChanged(e.latlng.lat, e.latlng.lng);
        });
        checkoutMarker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            onDestinationChanged(pos.lat, pos.lng);
        });

        // Try GPS
        useMyLocation();
    }

    function onDestinationChanged(lat, lng) {
        document.getElementById('destinationLat').value = lat;
        document.getElementById('destinationLng').value = lng;
        calculateAndShowRates(lat, lng);
    }

    function calculateAndShowRates(lat, lng) {
        const distanceKm = getDistanceKm(ORIGIN_LAT, ORIGIN_LNG, lat, lng);
        const gojekPrice = estimatePrice(distanceKm, 'gojek');
        const grabPrice = estimatePrice(distanceKm, 'grab');

        const section = document.getElementById('courierSection');
        const list = document.getElementById('courierList');
        const errDiv = document.getElementById('courierError');
        section.classList.remove('hidden');
        errDiv.classList.add('hidden');
        clearShippingSelection();

        const distText = distanceKm < 1 ? (distanceKm * 1000).toFixed(0) + ' m' : distanceKm.toFixed(1) + ' km';

        list.innerHTML = `
            <p class="text-xs text-slate-500 mb-2">Jarak dari toko: <span class="font-bold text-brand-700">${distText}</span></p>
            <label class="block cursor-pointer" for="courier_gojek">
                <input type="radio" name="_courier_select" id="courier_gojek" class="peer sr-only"
                    onchange="selectCourier('gojek','instant','Gojek GoSend',${gojekPrice},'Instan')">
                <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-green-500 peer-checked:bg-green-50/50 hover:bg-slate-50 transition-all flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🛵</span>
                        <div>
                            <div class="font-bold text-green-700 text-sm">Gojek GoSend</div>
                            <div class="text-xs text-slate-500">Estimasi: Instan (same day)</div>
                        </div>
                    </div>
                    <div class="font-bold text-brand-600 text-sm whitespace-nowrap">Rp${gojekPrice.toLocaleString('id-ID')}</div>
                </div>
            </label>
            <label class="block cursor-pointer" for="courier_grab">
                <input type="radio" name="_courier_select" id="courier_grab" class="peer sr-only"
                    onchange="selectCourier('grab','instant','Grab Express',${grabPrice},'Instan')">
                <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-green-500 peer-checked:bg-green-50/50 hover:bg-slate-50 transition-all flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🛵</span>
                        <div>
                            <div class="font-bold text-green-600 text-sm">Grab Express</div>
                            <div class="text-xs text-slate-500">Estimasi: Instan (same day)</div>
                        </div>
                    </div>
                    <div class="font-bold text-brand-600 text-sm whitespace-nowrap">Rp${grabPrice.toLocaleString('id-ID')}</div>
                </div>
            </label>
            <p class="text-xs text-slate-400 mt-1">* Estimasi ongkir berdasarkan jarak. Harga final dapat berbeda saat pemesanan kurir.</p>
        `;
    }

    function useMyLocation() {
        const status = document.getElementById('gpsStatus');
        if (!navigator.geolocation) {
            status.textContent = 'GPS tidak didukung browser Anda';
            return;
        }
        status.textContent = 'Mencari lokasi...';
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                if (checkoutMap && checkoutMarker) {
                    checkoutMap.setView([lat, lng], 15);
                    checkoutMarker.setLatLng([lat, lng]);
                    onDestinationChanged(lat, lng);
                }
                status.textContent = 'Lokasi ditemukan ✓';
                setTimeout(() => status.textContent = '', 3000);
            },
            function() {
                status.textContent = 'Tidak dapat mengakses lokasi. Tandai manual di peta.';
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function toggleDeliveryAddress(type) {
        const deliverySection = document.getElementById('deliveryAddressSection');
        const bopsSection = document.getElementById('bopsInfoSection');
        const codLabel = document.getElementById('payment-cod-label');
        const codRadio = document.getElementById('payment-cod-radio');
        
        if (type === 'delivery') {
            deliverySection.classList.remove('hidden');
            bopsSection.classList.add('hidden');
            if (codLabel) codLabel.classList.add('hidden');
            if (codRadio && codRadio.checked) {
                document.querySelector('input[name="payment_method"][value="midtrans"]').checked = true;
            }
            setTimeout(() => initCheckoutMap(), 150);
        } else {
            deliverySection.classList.add('hidden');
            bopsSection.classList.remove('hidden');
            if (codLabel) codLabel.classList.remove('hidden');
            clearShippingSelection();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('deliveryAddressSection').classList.contains('hidden')) {
            const codLabel = document.getElementById('payment-cod-label');
            if (codLabel) codLabel.classList.add('hidden');
            setTimeout(() => initCheckoutMap(), 300);
        }
    });

    function selectCourier(code, service, name, price, etd) {
        document.getElementById('shippingCostInput').value = price;
        document.getElementById('shippingCourierCode').value = code;
        document.getElementById('shippingCourierService').value = service;
        document.getElementById('shippingCourierName').value = name;
        document.getElementById('shippingEtd').value = etd;
        selectedShippingCost = price;
        updateTotalDisplay();
    }

    function clearShippingSelection() {
        selectedShippingCost = 0;
        ['shippingCostInput','shippingCourierCode','shippingCourierService','shippingCourierName','shippingEtd']
            .forEach(id => document.getElementById(id).value = '');
        updateTotalDisplay();
    }

    function updateTotalDisplay() {
        const shippingRow = document.getElementById('shippingCostRow');
        const shippingDisplay = document.getElementById('shippingCostDisplay');
        const totalDisplay = document.getElementById('totalDisplay');
        const total = CART_SUBTOTAL + selectedShippingCost;
        if (selectedShippingCost > 0) {
            shippingRow.classList.remove('hidden');
            shippingDisplay.textContent = 'Rp' + selectedShippingCost.toLocaleString('id-ID');
        } else {
            shippingRow.classList.add('hidden');
        }
        totalDisplay.textContent = 'Rp' + total.toLocaleString('id-ID');
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

</body>
</html>
