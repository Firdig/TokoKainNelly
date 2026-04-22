<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-12 rounded-xl object-cover shadow-lg shadow-brand-600/20 ring-1 ring-brand-200/50">
                    <span class="font-outfit font-bold text-2xl text-brand-900 tracking-tight">Toko Nelly</span>
                </a>
                <nav class="flex items-center gap-4">
                    <a href="{{ route('katalog') }}" class="text-slate-500 hover:text-brand-900 text-sm font-bold transition-colors">Katalog</a>
                    <a href="{{ route('cart.index') }}" class="text-slate-500 hover:text-brand-900 text-sm font-bold transition-colors">Keranjang</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-28 pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="font-outfit font-bold text-3xl text-brand-900 mb-2">Pesanan Saya</h1>
                <p class="text-slate-500">Lacak status pesanan Anda di sini.</p>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-brand-50">
                    <svg class="w-16 h-16 mx-auto text-brand-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h3 class="font-outfit font-bold text-xl text-brand-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-slate-500 mb-6">Anda belum memiliki pesanan. Yuk mulai belanja!</p>
                    <a href="{{ route('katalog') }}" class="inline-flex items-center px-6 py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition-colors shadow-md">
                        Jelajahi Katalog
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($orders as $order)
                    <a href="{{ route('orders.show', $order->id) }}" class="block bg-white rounded-2xl p-6 shadow-sm border border-brand-50 hover:shadow-md hover:border-brand-200 transition-all group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-outfit font-bold text-brand-900">{{ $order->invoice_number }}</span>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'ready_for_pickup' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'ready_for_pickup' => 'Siap Diambil',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-slate-500">
                                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    <span class="text-brand-300">•</span>
                                    <span class="capitalize">{{ $order->transaction_type === 'bops' ? 'Ambil di Toko' : ($order->transaction_type === 'delivery' ? 'Pengiriman' : 'POS') }}</span>
                                    <span class="text-brand-300">•</span>
                                    <span>{{ $order->items->count() }} item</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-outfit font-bold text-xl text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>
