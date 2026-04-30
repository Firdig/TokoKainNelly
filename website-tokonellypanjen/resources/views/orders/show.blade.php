<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan {{ $order->invoice_number }} - Toko Nelly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans flex flex-col">

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 w-full z-50 border-b border-brand-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-12 w-12 rounded-xl object-cover shadow-lg shadow-brand-600/20 ring-1 ring-brand-200/50">
                    <span class="font-outfit font-bold text-2xl text-brand-900 tracking-tight">Toko Nelly</span>
                </a>
                <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-brand-900 text-sm font-bold transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Pesanan
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-28 pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'ready_for_pickup' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu Konfirmasi',
                    'ready_for_pickup' => 'Siap Diambil di Toko',
                    'shipped' => 'Sedang Dikirim',
                    'completed' => 'Pesanan Selesai',
                    'cancelled' => 'Pesanan Dibatalkan',
                ];
            @endphp

            <!-- Order Header -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-50 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="font-outfit font-bold text-2xl text-brand-900 mb-1">{{ $order->invoice_number }}</h1>
                        <p class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Status Timeline -->
                <div class="flex items-center justify-between mb-2">
                    @php
                        $steps = $order->transaction_type === 'bops'
                            ? ['pending' => 'Dipesan', 'ready_for_pickup' => 'Siap Ambil', 'completed' => 'Selesai']
                            : ['pending' => 'Dipesan', 'shipped' => 'Dikirim', 'completed' => 'Selesai'];

                        $stepKeys = array_keys($steps);
                        $currentIndex = array_search($order->status, $stepKeys);
                        if ($currentIndex === false) $currentIndex = -1;
                    @endphp
                    @foreach($steps as $key => $label)
                        @php $index = array_search($key, $stepKeys); @endphp
                        <div class="flex-1 text-center">
                            <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center text-sm font-bold mb-1
                                {{ $index <= $currentIndex ? 'bg-brand-600 text-white' : 'bg-slate-200 text-slate-400' }}">
                                @if($index < $currentIndex)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <span class="text-xs font-medium {{ $index <= $currentIndex ? 'text-brand-700' : 'text-slate-400' }}">{{ $label }}</span>
                        </div>
                        @if(!$loop->last)
                            <div class="flex-1 h-0.5 mt-[-20px] {{ $index < $currentIndex ? 'bg-brand-600' : 'bg-slate-200' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- BOPS Pickup Instructions -->
                    @if($order->transaction_type === 'bops' && $order->pickup_code)
                    <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-3xl p-8 text-white shadow-lg">
                        <h3 class="font-outfit font-bold text-xl mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Instruksi Pengambilan di Toko
                        </h3>
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 mb-4">
                            <p class="text-sm text-white/80 mb-2">Kode Pengambilan Anda</p>
                            <p class="font-outfit font-extrabold text-4xl tracking-[0.3em]">{{ $order->pickup_code }}</p>
                        </div>
                        <div class="space-y-3 text-sm text-white/90">
                            @if($order->estimated_pickup_at)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <strong>Estimasi Siap Diambil:</strong><br>
                                    {{ $order->estimated_pickup_at->format('d M Y, H:i') }} WIB
                                </div>
                            </div>
                            @endif
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div>
                                    <strong>Lokasi Toko:</strong><br>
                                    Toko Kain Nelly, Pasar Panjen
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    Tunjukkan <strong>kode pengambilan</strong> di atas kepada kasir saat mengambil kain Anda.
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Order Items -->
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-brand-50">
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6">Detail Item</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center gap-4 pb-4 border-b border-brand-50 last:border-0 last:pb-0">
                                @if($item->productVariant && $item->productVariant->image_mime)
                                    <img src="{{ route('image.variant', $item->productVariant->id) }}" class="w-14 h-14 rounded-lg object-cover shadow-sm border border-slate-100" alt="">
                                @else
                                    <div class="w-14 h-14 rounded-lg shadow-sm border border-slate-200" style="background-color: {{ $item->productVariant->hex_code ?? '#ccc' }}"></div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-bold text-brand-900">{{ $item->productVariant->product->name ?? 'Produk' }}</div>
                                    <div class="text-sm text-brand-600 font-medium">{{ $item->productVariant->color_name ?? '' }}</div>
                                    <div class="text-sm text-slate-500">{{ $item->quantity }}m × Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="font-bold text-brand-900">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-brand-50 sticky top-28">
                        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6">Ringkasan</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Tipe</span>
                                <span class="font-bold text-brand-900 capitalize">{{ $order->transaction_type === 'bops' ? 'Ambil di Toko' : ($order->transaction_type === 'delivery' ? 'Pengiriman' : 'POS') }}</span>
                            </div>
                            @if($order->payment_method)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Pembayaran</span>
                                <span class="font-bold text-brand-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                            @endif
                            @if($order->customer_name)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Nama</span>
                                <span class="font-bold text-brand-900">{{ $order->customer_name }}</span>
                            </div>
                            @endif
                            @if($order->customer_phone)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Telepon</span>
                                <span class="font-bold text-brand-900">{{ $order->customer_phone }}</span>
                            </div>
                            @endif
                            @if($order->delivery_address)
                            <div class="pt-3 border-t border-brand-50">
                                <span class="text-slate-500 block mb-1">Alamat Pengiriman</span>
                                <span class="font-medium text-brand-900">{{ $order->delivery_address }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="border-t border-brand-100 mt-6 pt-6">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-brand-900 text-lg">Total</span>
                                <span class="font-outfit font-extrabold text-2xl text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
