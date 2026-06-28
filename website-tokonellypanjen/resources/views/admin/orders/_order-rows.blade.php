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
        <div class="flex items-center gap-1 mt-1">
            <span class="text-xs text-slate-400">{{ $order->items ? $order->items->count() : 0 }} barang</span>
            @if($order->payment_status === 'paid')
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400 ml-1"></span>
                <span class="text-[10px] font-bold text-green-600">Lunas</span>
            @elseif(in_array($order->payment_status, ['unpaid', 'pending']))
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400 ml-1"></span>
                <span class="text-[10px] font-bold text-amber-600">Belum Bayar</span>
            @endif
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($order->processedBy)
            <div class="text-sm font-medium text-brand-900">{{ $order->processedBy->name }}</div>
            <div class="text-[10px] text-slate-400 uppercase font-bold">{{ $order->processedBy->role }}</div>
        @else
            <span class="text-xs text-slate-400 italic">Belum diproses</span>
        @endif
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
        <div class="mb-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 text-brand-600 hover:text-brand-900 font-bold text-xs bg-brand-50 px-3 py-1.5 rounded-lg transition-colors border border-brand-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Detail Pesanan
            </a>
        </div>
        @if($order->status !== 'completed' && $order->status !== 'cancelled')
            @if($order->transaction_type == 'bops')
                <!-- BOPS Flow Actions -->
                <div class="flex flex-col gap-2 items-end">
                    @if($order->status == 'pending')
                        <!-- Tahap 2: Confirm Stock -->
                        <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="in_preparation">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md transition-all flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Confirm Stock
                            </button>
                        </form>
                    @elseif($order->status == 'in_preparation')
                        <div class="flex gap-2">
                            <!-- Tahap 3: Mark as Ready -->
                            <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ready_for_pickup">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md transition-all flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    Mark as Ready
                                </button>
                            </form>
                        </div>
                    @elseif($order->status == 'ready_for_pickup')
                        <!-- Code is visible, wait for Handover via Scanner -->
                        <div class="text-xs bg-blue-50 text-blue-700 border border-blue-200 px-3 py-2 rounded-lg font-bold flex items-center gap-2">
                            Kode: <span class="tracking-widest text-lg">{{ $order->pickup_code }}</span>
                        </div>
                    @endif
                    
                    <!-- Fallback Select Form for other statuses -->
                    <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST" class="flex gap-2 justify-end w-full mt-2">
                        @csrf
                        <select name="status" class="block w-full pl-2 pr-6 py-1.5 text-[11px] border border-slate-200 focus:outline-none focus:ring-brand-500 focus:border-brand-500 rounded bg-slate-50 shadow-sm font-medium text-slate-600">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_preparation" {{ $order->status == 'in_preparation' ? 'selected' : '' }}>Diproses</option>
                            <option value="ready_for_pickup" {{ $order->status == 'ready_for_pickup' ? 'selected' : '' }}>Siap (BOPS)</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-2 py-1.5 rounded font-bold text-[11px] shadow-sm transition-all">
                            Ubah
                        </button>
                    </form>
                </div>
            @else
                <!-- Regular Form for Delivery / POS -->
                <form action="{{ url('/admin/orders/' . $order->id . '/status') }}" method="POST" class="flex gap-2 justify-end">
                    @csrf
                    <select name="status" class="block w-full pl-3 pr-8 py-2 text-xs border border-slate-300 focus:outline-none focus:ring-brand-500 focus:border-brand-500 rounded-lg bg-white shadow-sm font-medium text-slate-700">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-3 py-2 rounded-lg font-bold text-xs shadow-md shadow-brand-600/20 transition-all hover:-translate-y-0.5">
                        Simpan
                    </button>
                </form>
            @endif
        @else
            <span class="text-xs text-slate-400 font-bold block bg-slate-50 border border-slate-100 px-3 py-2 rounded-lg inline-block text-center w-full">Closed Deal</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
        <h3 class="mt-2 text-sm font-medium text-brand-900">Belum ada pesanan masuk</h3>
    </td>
</tr>
@endforelse
