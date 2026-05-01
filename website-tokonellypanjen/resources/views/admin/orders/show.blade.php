@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->invoice_number)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}" class="p-2 bg-white rounded-full border border-slate-200 text-slate-500 hover:text-brand-600 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-outfit text-3xl font-bold text-brand-900">Pesanan {{ $order->invoice_number }}</h2>
                <p class="text-sm font-medium text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            @if($order->transaction_type == 'bops' && in_array($order->status, ['in_preparation', 'ready_for_pickup']))
                <a href="{{ url('/admin/orders/' . $order->id . '/picking-slip') }}" target="_blank" class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Picking Slip
                </a>
            @endif
        </div>
    </div>

    <!-- Stats & Status -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Status Card -->
        <div class="bg-white rounded-2xl p-6 border border-brand-100 shadow-sm col-span-1 md:col-span-2 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Saat Ini</p>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'in_preparation' => 'bg-indigo-100 text-indigo-800',
                        'ready_for_pickup' => 'bg-blue-100 text-blue-800',
                        'shipped' => 'bg-cyan-100 text-cyan-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800'
                    ];
                    $color = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-800';
                @endphp
                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-black uppercase tracking-wider {{ $color }}">
                    {{ str_replace('_', ' ', $order->status) }}
                </span>
            </div>
            
            <div class="text-right">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Pesanan</p>
                @if($order->transaction_type == 'pos')
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-purple-100 text-purple-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Kasir (POS)
                    </span>
                @elseif($order->transaction_type == 'bops')
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-blue-100 text-blue-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Ambil di Toko
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-bold bg-orange-100 text-orange-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        Kirim Alamat
                    </span>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Barang</p>
            <p class="text-2xl font-black text-brand-900">{{ $order->items ? $order->items->sum('quantity') : 0 }} <span class="text-sm font-medium text-slate-500">meter</span></p>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Harga</p>
            <p class="text-2xl font-black text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Order Items -->
            <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50">
                    <h3 class="font-outfit font-bold text-lg text-brand-900">Daftar Barang</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex gap-4 p-4 rounded-2xl border border-slate-100 hover:border-brand-200 hover:bg-brand-50/30 transition-all group">
                            <!-- Image -->
                            <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                                @if($item->productVariant && $item->productVariant->image_mime)
                                    <img src="{{ route('image.variant', $item->productVariant->id) }}" alt="Variant Image" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Detail -->
                            <div class="flex-1 flex flex-col justify-center">
                                <h4 class="font-bold text-brand-900 text-lg">{{ $item->productVariant->product->name ?? 'Produk Terhapus' }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        <span class="w-2.5 h-2.5 rounded-full border border-black/10 shadow-sm" style="background-color: {{ $item->productVariant->hex_code ?? '#ccc' }}"></span>
                                        {{ $item->productVariant->color_name ?? '-' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Price & Qty -->
                            <div class="text-right flex flex-col justify-center border-l border-slate-100 pl-6">
                                <p class="text-sm text-slate-500 font-medium">{{ $item->quantity }}m x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-lg font-black text-brand-600 mt-0.5">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-slate-100 flex justify-end">
                        <div class="w-64 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Subtotal Barang</span>
                                <span class="font-bold text-slate-700">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Ongkos Kirim</span>
                                <span class="font-bold text-slate-700">Rp0</span>
                            </div>
                            <div class="flex justify-between text-lg pt-3 border-t border-slate-200">
                                <span class="font-bold text-brand-900">Total Akhir</span>
                                <span class="font-black text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-3xl shadow-sm border border-brand-100 p-6">
                <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4 border-b border-brand-50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Pelanggan
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Nama Pembeli</p>
                        <p class="font-bold text-slate-800">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">No. WhatsApp / HP</p>
                        <p class="font-medium text-slate-800">{{ $order->customer_phone ?? '-' }}</p>
                    </div>
                    @if($order->transaction_type == 'delivery')
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Alamat Pengiriman</p>
                        <p class="font-medium text-slate-800 text-sm bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $order->delivery_address ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- BOPS Info -->
            @if($order->transaction_type == 'bops')
            <div class="bg-blue-50 rounded-3xl shadow-sm border border-blue-100 p-6">
                <h3 class="font-outfit font-bold text-lg text-blue-900 mb-4 border-b border-blue-200/50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Detail Pengambilan
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-blue-700/70 font-medium mb-1">Kode Verifikasi (Pickup Code)</p>
                        <div class="bg-white border-2 border-blue-200 px-4 py-2 rounded-xl text-center">
                            <span class="font-black text-2xl tracking-widest text-blue-700">{{ $order->pickup_code ?? 'BELUM ADA' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-blue-700/70 font-medium mb-1">Estimasi Diambil</p>
                        <p class="font-bold text-blue-900">{{ $order->estimated_pickup_at ? \Carbon\Carbon::parse($order->estimated_pickup_at)->format('d F Y, H:i') : '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Info -->
            <div class="bg-white rounded-3xl shadow-sm border border-brand-100 p-6">
                <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4 border-b border-brand-50 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Pembayaran
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Metode</p>
                        <p class="font-bold text-slate-800 uppercase">{{ $order->payment_method ?? 'TUNAI' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Status Pembayaran</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-800">
                            Lunas (Paid)
                        </span>
                    </div>
                    @if($order->payment_method != 'cash')
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Bukti Transfer</p>
                        @if($order->payment_proof)
                            <a href="{{ Storage::url($order->payment_proof) }}" target="_blank" class="text-brand-600 hover:text-brand-800 font-bold text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-slate-400 italic text-sm">Tidak ada bukti unggahan</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
