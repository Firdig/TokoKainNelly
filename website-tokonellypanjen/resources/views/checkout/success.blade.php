<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if($order->usesMidtrans() && $order->isPaymentPending())
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    @endif
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col justify-center py-12">

    <main class="max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-brand-100 overflow-hidden relative">
            
            <!-- Confetti background subtle -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLXNwYXJrbGVzIj48cGF0aCBkPSJtMTIgM2MxLjYyNSA1LjIyNSA0Ljc3NSA4LjM3NSA5IDEwLTIuMDc1IDIuODI1LTYuNTUgNS4xMjUtOSAxMC0zLjcwNi01LjQ1LTYuNzItOC4xMjUtOS0xMCAyLjUxMi0xLjk3NSA1Ljc4OC00LjIyNSA5LTEweiIvPjwvc3ZnPg==')] opacity-[0.02] -z-0"></div>

            <div class="relative z-10 p-8 sm:p-12">
                <!-- Header Success / Payment Status -->
                <div class="text-center mb-10">
                    @if($order->isPaid())
                        {{-- Paid: green checkmark --}}
                        <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div class="absolute -inset-2 border-2 border-green-200 rounded-full animate-ping opacity-50"></div>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 font-outfit mb-2">Terima Kasih!</h1>
                        <p class="text-slate-500 text-lg">Pembayaran berhasil. Pesanan Anda sedang diproses.</p>
                    @elseif($order->payment_method === 'cod')
                        {{-- COD: green checkmark (no online payment needed) --}}
                        <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div class="absolute -inset-2 border-2 border-green-200 rounded-full animate-ping opacity-50"></div>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 font-outfit mb-2">Pesanan Berhasil!</h1>
                        <p class="text-slate-500 text-lg">Pesanan Anda telah berhasil dibuat. Bayar saat menerima kain.</p>
                    @elseif($order->isPaymentPending())
                        {{-- Pending: amber clock --}}
                        <div class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner relative">
                            <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 font-outfit mb-2">Menunggu Pembayaran</h1>
                        <p class="text-slate-500 text-lg">Silakan selesaikan pembayaran untuk memproses pesanan Anda.</p>
                    @else
                        {{-- Expired/Failed: red X --}}
                        <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 font-outfit mb-2">Pembayaran {{ ucfirst($order->payment_status) }}</h1>
                        <p class="text-slate-500 text-lg">Pembayaran tidak berhasil. Pesanan telah dibatalkan dan stok dikembalikan.</p>
                    @endif
                </div>

                <!-- Invoice Card -->
                <div class="bg-brand-50/50 rounded-2xl border border-brand-100 p-6 sm:p-8 mb-8 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-brand-100 rounded-full opacity-50 blur-xl"></div>
                    <div class="absolute -left-4 -bottom-4 w-32 h-32 bg-brand-200 rounded-full opacity-30 blur-2xl"></div>

                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-brand-100 pb-6 mb-6">
                        <div>
                            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Nomor Invoice</span>
                            <div class="font-outfit font-bold text-xl text-brand-900 mt-1">{{ $order->invoice_number }}</div>
                            <div class="text-sm text-slate-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Status Pembayaran</span>
                            <div class="mt-2">
                                @php
                                    $payStatusColors = [
                                        'paid' => 'bg-green-100 text-green-800 border-green-200',
                                        'unpaid' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'expired' => 'bg-red-100 text-red-800 border-red-200',
                                        'failed' => 'bg-red-100 text-red-800 border-red-200',
                                        'cancelled' => 'bg-slate-100 text-slate-800 border-slate-200',
                                    ];
                                    $payColor = $payStatusColors[$order->payment_status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm border {{ $payColor }}">
                                    {{ $order->payment_status === 'paid' ? 'Lunas' : ($order->payment_status === 'unpaid' ? 'Belum Bayar' : ucfirst($order->payment_status)) }}
                                </span>
                            </div>
                            <div class="mt-2 text-sm text-brand-600 font-medium">
                                {{ $order->transaction_type === 'bops' ? 'Tipe: Ambil Di Toko (BOPS)' : 'Tipe: Pengiriman Kurir' }}
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <h3 class="font-bold text-brand-900 mb-4 font-outfit">Ringkasan Item:</h3>
                        <div class="space-y-4 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-sm border-b border-brand-50 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <div class="font-bold text-slate-700">{{ $item->productVariant->product->name }}</div>
                                    <div class="text-slate-500">{{ $item->quantity }} m x Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-bold text-brand-900">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative z-10 border-t border-brand-100 mt-6 pt-6">
                        @php $itemsSubtotal = $order->total_amount - $order->shipping_cost; @endphp
                        <div class="flex justify-between items-center text-sm text-slate-600 mb-2">
                            <span>Subtotal Produk</span>
                            <span class="font-bold text-brand-900">Rp{{ number_format($itemsSubtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                        <div class="flex justify-between items-center text-sm text-slate-600 mb-2">
                            <span>Ongkos Kirim <span class="text-xs text-slate-400">({{ $order->shipping_courier_name ?? '-' }})</span></span>
                            <span class="font-bold text-blue-600">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @if($order->shipping_etd)
                        <div class="text-xs text-slate-400 mb-2">Estimasi pengiriman: {{ $order->shipping_etd }}</div>
                        @endif
                        @endif
                        <div class="flex justify-between items-end pt-2">
                            <span class="font-bold text-brand-900 font-outfit">Total Pembayaran</span>
                            <span class="font-extrabold text-brand-600 font-outfit text-2xl sm:text-3xl">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($order->isPaid() && $order->midtrans_payment_type)
                    <div class="relative z-10 mt-4 pt-4 border-t border-brand-100 flex items-center gap-2 text-sm text-slate-500">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Dibayar via <strong class="text-slate-700">{{ str_replace('_', ' ', ucwords($order->midtrans_payment_type, '_')) }}</strong></span>
                        @if($order->paid_at)
                            <span class="text-slate-400">• {{ $order->paid_at->format('d M Y, H:i') }}</span>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Action Buttons (for pending orders - before admin confirms) -->
                @if($order->status === 'pending')
                <div class="mb-8 flex flex-col sm:flex-row gap-4">
                    @if($order->usesMidtrans() && $order->isPaymentPending())
                    <button id="pay-button"
                        class="w-full sm:flex-1 text-center px-8 py-4 bg-gradient-to-r from-brand-800 to-brand-900 text-white rounded-xl font-bold font-outfit text-lg shadow-xl shadow-brand-900/30 hover:-translate-y-1 hover:shadow-2xl transition-all flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Bayar Sekarang
                    </button>
                    @endif

                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="w-full @if($order->usesMidtrans() && $order->isPaymentPending()) sm:flex-1 @endif" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.');">
                        @csrf
                        <button type="submit" class="w-full h-full text-center px-8 py-4 bg-white text-red-600 border-2 border-red-200 rounded-xl font-bold font-outfit text-lg hover:bg-red-50 hover:border-red-300 transition-all flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
                @if($order->usesMidtrans() && $order->isPaymentPending())
                <p class="text-center text-xs text-slate-400 mt-[-1rem] mb-8">Klik Bayar Sekarang untuk membuka halaman pembayaran Midtrans</p>
                @endif
                @endif

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 text-sm text-green-800 font-medium">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('warning'))
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 text-sm text-amber-800 font-medium">
                    {{ session('warning') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 text-sm text-red-800 font-medium">
                    {{ session('error') }}
                </div>
                @endif
                @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 text-sm text-blue-800 font-medium">
                    {{ session('info') }}
                </div>
                @endif

                <!-- Next Steps Info -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-10 flex gap-4">
                    <div class="shrink-0 text-blue-500 pt-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-1">Langkah Selanjutnya</h4>
                        <p class="text-sm text-blue-800 leading-relaxed">
                            @if($order->isPaymentPending() && $order->payment_method === 'midtrans')
                                Silakan selesaikan pembayaran Anda melalui tombol "Bayar Sekarang" di atas. Pesanan akan diproses setelah pembayaran dikonfirmasi.
                            @elseif($order->transaction_type === 'bops')
                                Admin kami sedang menyiapkan pesanan Anda. Silakan tunjukkan Invoice ini saat mengambil kain di Toko Utama (Kepanjen).
                            @elseif($order->payment_method === 'cod')
                                Admin kami sedang memproses pesanan Anda. Siapkan pembayaran tunai saat kain tiba di alamat Anda.
                            @else
                                Admin kami sedang memverifikasi pembayaran Anda. Pesanan akan segera dikirim melalui kurir menuju alamat Anda.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- BOPS Pickup Code (only shown after payment) -->
                @if($order->transaction_type === 'bops' && $order->pickup_code && $order->isPaid())
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-6 mb-10">
                    <h4 class="font-bold text-purple-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Kode Pengambilan
                    </h4>
                    <div class="bg-white border-2 border-purple-200 rounded-xl px-6 py-3 text-center">
                        <span class="font-black text-3xl tracking-[0.3em] text-purple-700 font-outfit">{{ $order->pickup_code }}</span>
                    </div>
                    <p class="text-xs text-purple-600 mt-2 text-center">Tunjukkan kode ini kepada kasir saat mengambil pesanan</p>
                </div>
                @elseif($order->transaction_type === 'bops' && $order->pickup_code && $order->isPaymentPending())
                {{-- BOPS order not yet paid: show notice instead of code --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-10">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-amber-900 mb-1">Kode Pengambilan Belum Tersedia</h4>
                            <p class="text-sm text-amber-700 leading-relaxed">Kode pengambilan (BOPS) akan ditampilkan setelah pembayaran Anda dikonfirmasi. Silakan selesaikan pembayaran terlebih dahulu.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="window.print()" class="px-8 py-4 bg-white border-2 border-brand-100 text-brand-900 rounded-xl font-bold font-outfit hover:border-brand-300 hover:bg-brand-50 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Invoice
                    </button>
                    <a href="{{ route('katalog') }}" class="px-8 py-4 bg-brand-900 text-white rounded-xl font-bold font-outfit shadow-xl shadow-brand-900/30 hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                        Belanja Lagi
                    </a>
                </div>

            </div>
        </div>
    </main>

@if($order->usesMidtrans() && $order->isPaymentPending())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const snapToken = @json($order->snap_token);

        if (payButton && snapToken) {
            payButton.addEventListener('click', function() {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        // Stay on page, user can retry
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                    }
                });
            });
        }
    });
</script>
@endif

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

</body>
</html>
