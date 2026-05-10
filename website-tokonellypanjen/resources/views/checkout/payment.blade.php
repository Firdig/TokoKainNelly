<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Midtrans Snap JS -->
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-12 rounded-xl object-cover shadow-lg shadow-brand-600/20 ring-1 ring-brand-200/50">
                    <span class="font-outfit font-bold text-2xl text-brand-900 tracking-tight">Pembayaran</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-32 pb-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Order Summary Card -->
            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-brand-100 mb-8">

                <!-- Status Header -->
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 relative" id="statusIcon">
                        <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-brand-900 font-outfit mb-2" id="statusTitle">Menunggu Pembayaran</h1>
                    <p class="text-slate-500" id="statusMessage">Silakan selesaikan pembayaran Anda untuk memproses pesanan.</p>
                </div>

                <!-- Invoice Info -->
                <div class="bg-brand-50/50 rounded-2xl border border-brand-100 p-6 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
                        <div>
                            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Nomor Invoice</span>
                            <div class="font-outfit font-bold text-lg text-brand-900 mt-1">{{ $order->invoice_number }}</div>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Tipe</span>
                            <div class="mt-1 text-sm font-bold text-brand-600">
                                {{ $order->transaction_type === 'bops' ? 'Ambil Di Toko (BOPS)' : 'Pengiriman Kurir' }}
                            </div>
                        </div>
                    </div>

                    <!-- Item List -->
                    <div class="space-y-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center text-sm border-b border-brand-50 pb-3 last:border-0 last:pb-0">
                            <div>
                                <div class="font-bold text-slate-700">{{ $item->productVariant->product->name ?? 'Produk' }}</div>
                                <div class="text-slate-500">{{ $item->quantity }} m x Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="font-bold text-brand-900">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-brand-100 mt-4 pt-4 flex justify-between items-end">
                        <span class="font-bold text-brand-900 font-outfit">Total Pembayaran</span>
                        <span class="font-extrabold text-brand-600 font-outfit text-2xl">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pay Button -->
                <button id="pay-button"
                    class="w-full text-center px-8 py-4 bg-gradient-to-r from-brand-800 to-brand-900 text-white rounded-xl font-bold font-outfit text-lg shadow-xl shadow-brand-900/30 hover:-translate-y-1 hover:shadow-2xl transition-all flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Bayar Sekarang
                </button>

                <p class="text-center text-xs text-slate-400 mt-4 leading-relaxed">
                    Anda akan diarahkan ke halaman pembayaran aman Midtrans.<br>
                    Mendukung Transfer Bank, QRIS, GoPay, ShopeePay, dan lainnya.
                </p>
            </div>

            <!-- Security Info -->
            <div class="flex items-center justify-center gap-3 text-slate-400 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Pembayaran diproses secara aman oleh <strong class="text-slate-500">Midtrans</strong></span>
            </div>

        </div>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        const snapToken = @json($order->snap_token);

        if (!snapToken) {
            payButton.disabled = true;
            payButton.textContent = 'Token pembayaran tidak tersedia';
            payButton.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // Auto-trigger Snap popup on page load
        triggerSnap();

        // Also allow manual re-trigger via button
        payButton.addEventListener('click', function() {
            triggerSnap();
        });

        function triggerSnap() {
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    updateStatus('success', 'Pembayaran Berhasil!', 'Terima kasih, pesanan Anda sedang diproses.');
                    // Redirect to success page after brief delay
                    setTimeout(function() {
                        window.location.href = '{{ route("checkout.success", $order->id) }}';
                    }, 1500);
                },
                onPending: function(result) {
                    updateStatus('pending', 'Menunggu Pembayaran', 'Silakan selesaikan pembayaran sesuai instruksi yang diberikan.');
                },
                onError: function(result) {
                    updateStatus('error', 'Pembayaran Gagal', 'Terjadi kesalahan. Silakan coba lagi atau pilih metode lain.');
                },
                onClose: function() {
                    // User closed the popup without completing payment
                    console.log('Payment popup closed by user');
                }
            });
        }

        function updateStatus(type, title, message) {
            const icon = document.getElementById('statusIcon');
            const titleEl = document.getElementById('statusTitle');
            const messageEl = document.getElementById('statusMessage');

            titleEl.textContent = title;
            messageEl.textContent = message;

            if (type === 'success') {
                icon.className = 'w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4';
                icon.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                payButton.style.display = 'none';
            } else if (type === 'error') {
                icon.className = 'w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4';
                icon.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            }
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

</body>
</html>
