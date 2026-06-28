{{-- ═══════════════════════════════════════════════════════════════
     TAB: PENJUALAN & PEMBAYARAN (GABUNGAN)
     Menggabungkan data penjualan keseluruhan + rekapitulasi pembayaran
═══════════════════════════════════════════════════════════════ --}}

<div class="space-y-8">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Omzet (All-Time)</p>
            <p class="text-3xl font-black text-brand-900 relative z-[1]">Rp{{ number_format($salesTotalRevenueAllTime, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Omzet Bulan Ini</p>
            <p class="text-3xl font-black text-brand-900 relative z-[1]">Rp{{ number_format($salesTotalRevenueThisMonth, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi</p>
            <p class="text-3xl font-black text-brand-900 relative z-[1]">{{ number_format($salesTotalOrdersAllTime, 0, ',', '.') }} <span class="text-sm font-medium text-slate-500">pesanan</span></p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-amber-500 mr-4 mt-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p>
            <p class="text-3xl font-black text-brand-900 relative z-[1]">Rp{{ number_format($payGrandTotal, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 p-6">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-6">Tren Penjualan (30 Hari Terakhir)</h3>
        <div class="w-full h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         BAGIAN REKAPITULASI PEMBAYARAN (Digabung)
    ═══════════════════════════════════════════════════════════════ --}}

    {{-- Filter Periode Pembayaran --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6">
        <h3 class="font-outfit font-bold text-lg text-brand-900 mb-4">Rekapitulasi Pembayaran</h3>
        <form method="GET" action="{{ route('admin.report-center.index') }}" class="flex flex-wrap items-end gap-3">
            <input type="hidden" name="tab" value="sales">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="pay_start_date" value="{{ $payStartDate->toDateString() }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="pay_end_date" value="{{ $payEndDate->toDateString() }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
            </div>
            <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Tampilkan</button>
            <a href="{{ route('admin.report-center.index', ['tab' => 'sales']) }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-bold text-sm transition-all">Hari Ini</a>
            <button type="button" onclick="window.print()" class="ml-auto bg-brand-600 hover:bg-brand-700 text-white px-5 py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
        </form>
    </div>

    {{-- Summary Pembayaran Periode --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Pendapatan Periode</p>
            <p class="text-3xl font-black text-brand-900">Rp{{ number_format($payGrandTotal, 0, ',', '.') }}</p>
            <p class="text-sm text-slate-500 mt-1">{{ $payStartDate->format('d M Y') }} - {{ $payEndDate->format('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-brand-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi Periode</p>
            <p class="text-3xl font-black text-brand-900">{{ number_format($payGrandCount) }} <span class="text-sm font-medium text-slate-500">transaksi</span></p>
        </div>
    </div>

    {{-- Tabel Rekapitulasi Per Metode --}}
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Rekapitulasi Per Metode Pembayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Metode Pembayaran</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Jumlah Transaksi</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total Nominal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($paySummary as $row)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-brand-900 text-sm">
                                {{ $payLabels[$row->payment_method] ?? ucfirst(str_replace('_', ' ', $row->payment_method)) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ number_format($row->transaction_count) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-brand-600">Rp{{ number_format($row->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-500">
                                {{ $payGrandTotal > 0 ? number_format(($row->total_amount / $payGrandTotal) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada data transaksi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($paySummary->isNotEmpty())
                <tfoot class="bg-brand-50">
                    <tr>
                        <td class="px-6 py-4 font-bold text-brand-900 text-sm">Total</td>
                        <td class="px-6 py-4 text-center font-bold text-brand-900 text-sm">{{ number_format($payGrandCount) }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">Rp{{ number_format($payGrandTotal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-brand-900 text-sm">100%</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Transaksi Tanpa Nomor Referensi --}}
    @if($payMissingRefOrders->isNotEmpty())
    <div class="bg-amber-50 rounded-3xl shadow-sm border border-amber-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-amber-200 bg-amber-100/50 flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
            <h3 class="font-outfit font-bold text-lg text-amber-900">Transaksi Tanpa Nomor Referensi ({{ $payMissingRefOrders->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-amber-200">
                <thead class="bg-amber-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-amber-700 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-amber-700 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-amber-700 uppercase">Metode</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-amber-700 uppercase">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100 bg-white">
                    @foreach($payMissingRefOrders as $order)
                        <tr>
                            <td class="px-6 py-3 text-sm font-bold text-brand-900">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-brand-600 hover:underline">{{ $order->invoice_number }}</a>
                            </td>
                            <td class="px-6 py-3 text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-3 text-center text-sm">
                                <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">
                                    {{ $payLabels[$order->payment_method] ?? $order->payment_method }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-right text-sm font-bold text-brand-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         RIWAYAT TRANSAKSI (Tabel Penjualan)
    ═══════════════════════════════════════════════════════════════ --}}

    {{-- Filter & Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-100 bg-brand-50/50 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <h3 class="font-outfit font-bold text-lg text-brand-900">Riwayat Transaksi</h3>

            <form method="GET" action="{{ route('admin.report-center.index') }}" class="flex flex-wrap gap-2">
                <input type="hidden" name="tab" value="sales">
                <input type="date" name="sales_start_date" value="{{ request('sales_start_date') }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
                <span class="text-slate-500 self-center">s/d</span>
                <input type="date" name="sales_end_date" value="{{ request('sales_end_date') }}" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">

                <select name="sales_type" class="px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-brand-500 focus:border-brand-500 bg-white">
                    <option value="">Semua Kanal</option>
                    <option value="pos" {{ request('sales_type') == 'pos' ? 'selected' : '' }}>Kasir (POS)</option>
                    <option value="bops" {{ request('sales_type') == 'bops' ? 'selected' : '' }}>Ambil di Toko (BOPS)</option>
                    <option value="delivery" {{ request('sales_type') == 'delivery' ? 'selected' : '' }}>Kirim Alamat</option>
                </select>

                <button type="submit" class="bg-brand-600 hover:bg-brand-900 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Filter</button>
                @if(request()->has('sales_start_date'))
                    <a href="{{ route('admin.report-center.index', ['tab' => 'sales']) }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-100">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Pelaku / Pelanggan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Kanal</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Pembayaran</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($salesOrders as $order)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-brand-900 text-sm">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-brand-600 hover:underline">{{ $order->invoice_number }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->transaction_type == 'pos')
                                    {{-- POS: Kasir only, no customer --}}
                                    <div class="text-sm text-brand-900 font-medium">{{ $order->user->name ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase">Kasir</div>
                                @else
                                    {{-- BOPS/Delivery: staff + customer --}}
                                    <div class="text-sm text-brand-900 font-medium">{{ $order->customer_name ?? ($order->user->name ?? 'Walk-in') }}</div>
                                    @if($order->processedBy)
                                        <div class="text-[10px] text-brand-500 font-semibold mt-0.5">Staff: {{ $order->processedBy->name }}</div>
                                    @endif
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($order->transaction_type == 'pos')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">Kasir</span>
                                @elseif($order->transaction_type == 'bops')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-purple-100 text-purple-800 uppercase tracking-wider">BOPS</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-green-100 text-green-800 uppercase tracking-wider">Kirim</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 uppercase tracking-wider">
                                    {{ $payLabels[$order->payment_method] ?? ucfirst(str_replace('_', ' ', $order->payment_method ?? '-')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-brand-600">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Belum ada data penjualan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-brand-100 bg-white">
            {{ $salesOrders->appends(request()->query())->links() }}
        </div>
    </div>
</div>
