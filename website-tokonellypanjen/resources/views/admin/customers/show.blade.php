@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.customers.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">{{ $customer->name }}</h2>
            <p class="mt-1 text-sm text-slate-500">Pelanggan sejak {{ $customer->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <!-- Customer Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-50">
            <div class="text-sm text-slate-500 mb-1">Email</div>
            <div class="font-bold text-brand-900">{{ $customer->email }}</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-50">
            <div class="text-sm text-slate-500 mb-1">Telepon</div>
            <div class="font-bold text-brand-900">{{ $customer->phone ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-50">
            <div class="text-sm text-slate-500 mb-1">Alamat</div>
            <div class="font-bold text-brand-900 text-sm">{{ $customer->address ?? '-' }}</div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-2xl p-6 text-white">
            <div class="text-sm text-white/80 mb-1">Total Pesanan</div>
            <div class="font-outfit font-extrabold text-3xl">{{ $customer->orders_count }}</div>
        </div>
        <div class="bg-gradient-to-br from-brand-800 to-brand-900 rounded-2xl p-6 text-white">
            <div class="text-sm text-white/80 mb-1">Total Belanja</div>
            <div class="font-outfit font-extrabold text-3xl">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Order History -->
    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Riwayat Pesanan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-brand-900 uppercase">Item</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($orders as $order)
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'in_preparation' => 'bg-orange-100 text-orange-700',
                            'ready_for_pickup' => 'bg-blue-100 text-blue-700',
                            'shipped' => 'bg-indigo-100 text-indigo-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                        $typeLabels = [
                            'bops' => 'BOPS',
                            'delivery' => 'Delivery',
                            'pos' => 'POS',
                        ];
                    @endphp
                    <tr class="hover:bg-brand-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-brand-900">{{ $order->invoice_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold px-2 py-1 rounded-full bg-brand-100 text-brand-700">{{ $typeLabels[$order->transaction_type] ?? $order->transaction_type }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-slate-600">{{ $order->items->count() }}</td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-brand-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-brand-600 hover:text-brand-800 text-xs font-bold">Lihat</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">Pelanggan ini belum memiliki pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-brand-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
