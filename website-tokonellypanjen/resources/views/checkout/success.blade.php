<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col justify-center py-12">

    <main class="max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-brand-100 overflow-hidden relative">
            
            <!-- Confetti background subtle -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLXNwYXJrbGVzIj48cGF0aCBkPSJtMTIgM2MxLjYyNSA1LjIyNSA0Ljc3NSA4LjM3NSA5IDEwLTIuMDc1IDIuODI1LTYuNTUgNS4xMjUtOSAxMC0zLjcwNi01LjQ1LTYuNzItOC4xMjUtOS0xMCAyLjUxMi0xLjk3NSA1Ljc4OC00LjIyNSA5LTEweiIvPjwvc3ZnPg==')] opacity-[0.02] -z-0"></div>

            <div class="relative z-10 p-8 sm:p-12">
                <!-- Header Success -->
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner animate-fade-in relative">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <div class="absolute -inset-2 border-2 border-green-200 rounded-full animate-ping opacity-50"></div>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-900 font-outfit mb-2">Terima Kasih!</h1>
                    <p class="text-slate-500 text-lg">Pesanan Anda telah berhasil dibuat.</p>
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
                            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Status Order</span>
                            <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm bg-yellow-100 text-yellow-800 border border-yellow-200">
                                {{ str_replace('_', ' ', $order->status) }}
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

                    <div class="relative z-10 border-t border-brand-100 mt-6 pt-6 flex justify-between items-end">
                        <span class="font-bold text-brand-900 font-outfit">Total Pembayaran</span>
                        <span class="font-extrabold text-brand-600 font-outfit text-2xl sm:text-3xl">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Next Steps Info -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-10 flex gap-4">
                    <div class="shrink-0 text-blue-500 pt-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-1">Langkah Selanjutnya</h4>
                        <p class="text-sm text-blue-800 leading-relaxed">
                            @if($order->transaction_type === 'bops')
                                Admin kami sedang menyiapkan pesanan Anda. Silakan tunjukkan Invoice ini saat mengambil kain di Toko Utama (Kepanjen).
                            @else
                                Admin kami sedang memverifikasi pembayaran Anda. Pesanan akan segera dikirim melalui kurir menuju alamat Anda.
                            @endif
                        </p>
                    </div>
                </div>

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

</body>
</html>
