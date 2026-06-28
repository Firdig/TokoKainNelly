@extends('layouts.admin')

@section('title', 'Manajemen Pesanan Masuk')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Daftar Pesanan Masuk</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau dan kelola pesanan pengiriman (Delivery), pengambilan lokal (BOPS), dan transaksi langsung di toko (POS).</p>
        </div>
    </div>

    {{-- Filter: Tipe Transaksi --}}
    <div class="mb-4 flex flex-wrap gap-2">
        <span class="self-center text-xs font-bold text-slate-500 uppercase tracking-wider mr-2">Tipe:</span>
        <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('type', 'page'), []))) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('type') ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Semua</a>
        <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('page'), ['type' => 'bops']))) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('type') == 'bops' ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">BOPS (Pickup)</a>
        <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('page'), ['type' => 'delivery']))) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('type') == 'delivery' ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">Delivery</a>
        <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('page'), ['type' => 'pos']))) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('type') == 'pos' ? 'bg-brand-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">POS (Kasir)</a>
    </div>

    {{-- Filter: Status --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <span class="self-center text-xs font-bold text-slate-500 uppercase tracking-wider mr-2">Status:</span>
        <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('status', 'page'), []))) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border {{ !request('status') ? 'bg-brand-900 text-white border-brand-900 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Semua</a>
        @php
            $statusFilters = [
                'pending' => ['label' => 'Pending', 'active_class' => 'bg-yellow-100 text-yellow-800 border-yellow-300'],
                'in_preparation' => ['label' => 'Diproses', 'active_class' => 'bg-blue-100 text-blue-800 border-blue-300'],
                'ready_for_pickup' => ['label' => 'Siap Diambil', 'active_class' => 'bg-indigo-100 text-indigo-800 border-indigo-300'],
                'shipped' => ['label' => 'Dikirim', 'active_class' => 'bg-cyan-100 text-cyan-800 border-cyan-300'],
                'completed' => ['label' => 'Selesai', 'active_class' => 'bg-green-100 text-green-800 border-green-300'],
                'cancelled' => ['label' => 'Dibatalkan', 'active_class' => 'bg-red-100 text-red-800 border-red-300'],
            ];
        @endphp
        @foreach($statusFilters as $statusKey => $statusInfo)
            <a href="{{ url('/admin/orders?' . http_build_query(array_merge(request()->except('page'), ['status' => $statusKey]))) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border {{ request('status') == $statusKey ? $statusInfo['active_class'] . ' shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                {{ $statusInfo['label'] }}
            </a>
        @endforeach
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit">Diproses Oleh</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-40">Status Terkini</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-brand-900 uppercase tracking-wider font-outfit w-56">Aksi & Update</th>
                    </tr>
                </thead>
                <tbody id="order-table-body" class="bg-white divide-y divide-brand-50 font-inter">
                    @include('admin.orders._order-rows', ['orders' => $orders])
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
