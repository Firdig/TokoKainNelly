<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
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

                            <!-- Delivery Address (shown only for Delivery) -->
                            <div id="deliveryAddressSection" class="mt-6 {{ old('transaction_type') !== 'delivery' ? 'hidden' : '' }}">
                                <label class="block text-sm font-bold text-brand-900 mb-2">Alamat Pengiriman <span class="text-red-400">*</span></label>
                                <textarea name="delivery_address" rows="3"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm"
                                    placeholder="Masukkan alamat lengkap pengiriman">{{ old('delivery_address') }}</textarea>
                                @error('delivery_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
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
                                <label class="flex items-center justify-between p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <input type="radio" name="payment_method" value="transfer_bca" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required {{ old('payment_method') === 'transfer_bca' ? 'checked' : '' }}>
                                        <span class="font-bold text-brand-900">Transfer Bank BCA</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">Manual</span>
                                </label>
                                
                                <label class="flex items-center justify-between p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <input type="radio" name="payment_method" value="qris" class="w-4 h-4 text-brand-600 focus:ring-brand-500" {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                                        <span class="font-bold text-brand-900">QRIS (Gopay, OVO, Dana)</span>
                                    </div>
                                </label>

                                <label class="flex items-center justify-between p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <input type="radio" name="payment_method" value="cod" class="w-4 h-4 text-brand-600 focus:ring-brand-500" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                        <span class="font-bold text-brand-900">Bayar di Tempat (COD/Di Toko)</span>
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
                                    <span>Subtotal</span>
                                    <span class="font-bold text-brand-900">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-slate-600 mb-4">
                                    <span>Biaya Layanan</span>
                                    <span class="font-bold text-brand-900">Gratis</span>
                                </div>
                                <div class="flex justify-between items-end">
                                    <span class="font-bold text-brand-900 text-lg">Total</span>
                                    <span class="font-extrabold text-brand-600 font-outfit text-3xl">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
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
    function toggleDeliveryAddress(type) {
        const deliverySection = document.getElementById('deliveryAddressSection');
        const bopsSection = document.getElementById('bopsInfoSection');
        
        if (type === 'delivery') {
            deliverySection.classList.remove('hidden');
            bopsSection.classList.add('hidden');
        } else {
            deliverySection.classList.add('hidden');
            bopsSection.classList.remove('hidden');
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

</body>
</html>
