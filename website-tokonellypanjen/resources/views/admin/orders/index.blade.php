@extends('layouts.admin')

@section('title', 'Manajemen Pesanan Masuk')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Daftar Pesanan Masuk</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau dan kelola pengiriman (Delivery) dan pengambilan lokal (BOPS).</p>
        </div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <a href="{{ url('/admin/orders') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('type') ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Semua</a>
            <a href="{{ url('/admin/orders?type=bops') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('type') == 'bops' ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">BOPS (Pickup)</a>
            <a href="{{ url('/admin/orders?type=delivery') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('type') == 'delivery' ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Delivery</a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit">Invoice</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit">Tipe Transaksi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit">Total Nominal</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-40">Status Terkini</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-56">Aksi & Update</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-brand-50 font-inter">
                    @forelse($orders as $order)
                    <tr class="hover:bg-brand-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-brand-900">{{ $order->invoice_number }}</div>
                            <div class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                                {{ $order->transaction_type == 'pos' ? 'bg-blue-100 text-blue-800' : ($order->transaction_type == 'bops' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800') }}">
                                {{ $order->transaction_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            <div class="text-xs text-slate-400 mt-1">{{ $order->items ? $order->items->count() : 0 }} barang</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'ready_for_pickup' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                    'shipped' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200'
                                ];
                                $color = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold uppercase border shadow-sm {{ $color }}">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            @if($order->status !== 'completed' && $order->status !== 'cancelled')
                            <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST" class="flex gap-2 justify-end">
                                @csrf
                                <select name="status" class="block w-full pl-3 pr-8 py-2 text-xs border border-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 rounded-lg bg-white shadow-sm font-medium text-slate-700">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    @if($order->transaction_type == 'bops')
                                        <option value="ready_for_pickup" {{ $order->status == 'ready_for_pickup' ? 'selected' : '' }}>Siap (BOPS)</option>
                                    @else
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    @endif
                                    <option value="completed">Selesai</option>
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                                <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md shadow-brand-600/20 transition-all hover:-translate-y-0.5">
                                    Simpan
                                </button>
                            </form>
                            @else
                                <span class="text-xs text-slate-400 font-bold block bg-slate-50 border border-slate-100 px-3 py-2 rounded-lg inline-block text-center w-full">Closed Deal</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <h3 class="mt-2 text-sm font-medium text-brand-900">Belum ada pesanan masuk</h3>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
