@extends('layouts.admin')

@section('title', 'Manajemen Data Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-outfit text-3xl font-bold text-brand-900">Data Pelanggan</h2>
            <p class="mt-1 text-sm text-slate-500">Total <span class="font-bold text-brand-600">{{ $totalCustomers }}</span> pelanggan terdaftar.</p>
        </div>

        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau telepon..."
                class="px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm outline-none w-72">
            <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 transition-colors">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('admin.customers.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="bg-white shadow-sm border border-brand-100 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-brand-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Alamat</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-brand-900 uppercase">Pesanan</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Total Belanja</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-brand-900 uppercase">Bergabung</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-brand-900 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-brand-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold font-outfit text-sm">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-brand-900">{{ $customer->name }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 max-w-[200px] truncate">{{ $customer->address ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-700">
                                {{ $customer->orders_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-brand-900">
                            Rp{{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-slate-500">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-brand-600 hover:text-brand-800 bg-brand-50 hover:bg-brand-100 p-2 rounded-lg transition-colors inline-block" title="Lihat Detail">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            @if(request('search'))
                                Tidak ditemukan pelanggan dengan kata kunci "{{ request('search') }}".
                            @else
                                Belum ada pelanggan yang terdaftar.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-brand-100">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
