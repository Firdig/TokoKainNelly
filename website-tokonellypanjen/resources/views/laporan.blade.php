<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penjualan Harian - Toko Kain Nelly</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-50 min-h-screen font-sans">
    
    <!-- Top Navigation (Hidden on print) -->
    <nav class="bg-white border-b border-brand-100 shadow-sm print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Toko Kain Nelly" class="h-8 w-8 rounded object-cover shadow-sm">
                    <span class="font-outfit font-bold text-lg text-brand-900">Admin Panel <span class="text-brand-400 font-normal ml-2">| Laporan Harian</span></span>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="/kasir" class="text-sm font-medium text-brand-600 hover:text-brand-900 transition-colors">Kembali ke Kasir</a>
                    <button onclick="window.print()" class="px-5 py-2 bg-brand-600 hover:bg-brand-900 text-white text-sm font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 print:p-0 print:m-0 print:max-w-none">
        
        <!-- Document Canvas -->
        <main class="bg-white rounded-2xl shadow-sm border border-brand-100 p-10 print:shadow-none print:border-none print:rounded-none">
            
            <!-- Report Header -->
            <div class="text-center mb-10 border-b-2 border-brand-900 pb-8">
                <h2 class="font-outfit text-3xl font-bold tracking-tight text-brand-900 uppercase">Toko Kain Nelly</h2>
                <h3 class="font-inter text-lg font-medium text-brand-600 mt-1 uppercase tracking-widest">Cabang Kepanjen</h3>
                <div class="mt-6 inline-block bg-brand-50 border border-brand-100 px-6 py-2 rounded-lg">
                    <p class="text-brand-900 text-sm font-semibold">Laporan Rekap Penjualan Harian</p>
                    <p class="text-brand-600 text-xs mt-1">Tanggal: {{ $hariIni->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Report Table -->
            <div class="overflow-x-auto rounded-xl border border-brand-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand-900 text-white font-outfit text-sm">
                            <th class="py-4 px-4 font-semibold w-12 text-center">No</th>
                            <th class="py-4 px-4 font-semibold">Nomor Nota</th>
                            <th class="py-4 px-4 font-semibold text-center w-24">Waktu</th>
                            <th class="py-4 px-4 font-semibold w-32">Tipe</th>
                            <th class="py-4 px-4 font-semibold">Pelaku / Pelanggan</th>
                            <th class="py-4 px-4 font-semibold text-right">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody class="font-inter text-sm divide-y divide-brand-100">
                        @forelse($orders as $index => $order)
                        <tr class="hover:bg-brand-50 transition-colors even:bg-slate-50">
                            <td class="py-3 px-4 text-center text-slate-500">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium text-brand-900">{{ $order->invoice_number }}</td>
                            <td class="py-3 px-4 text-center text-slate-500">{{ $order->created_at->format('H:i:s') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $order->transaction_type == 'pos' ? 'bg-blue-100 text-blue-800' : 
                                      ($order->transaction_type == 'bops' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                    {{ strtoupper($order->transaction_type) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($order->transaction_type == 'pos')
                                    {{-- POS: hanya nama kasir, tanpa nama pelanggan --}}
                                    <div class="text-sm text-brand-900 font-medium">
                                        Kasir: {{ $order->user->name ?? ($order->processedBy->name ?? '-') }}
                                    </div>
                                @else
                                    {{-- BOPS/Delivery: nama staff + nama pelanggan --}}
                                    @if($order->processedBy)
                                        <div class="text-xs text-brand-600 font-semibold">
                                            Staff: {{ $order->processedBy->name }}
                                        </div>
                                    @endif
                                    <div class="text-sm text-brand-900 font-medium">
                                        {{ $order->customer_name ?? ($order->user->name ?? 'Walk-in') }}
                                    </div>
                                    @if($order->payment_status !== 'paid')
                                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded">Belum Bayar</span>
                                    @endif
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-medium text-brand-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Belum ada transaksi tercatat untuk hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-brand-50 border-t-2 border-brand-200">
                        <tr>
                            <td colspan="5" class="py-5 px-6 text-right font-outfit font-bold text-brand-900 text-sm uppercase tracking-wide">Total Omzet Harian:</td>
                            <td class="py-5 px-6 text-right font-outfit font-bold text-accent-500 text-xl">
                                Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Signatures Structure (Optimized for print) -->
            <div class="mt-20 flex justify-between px-10">
                <div class="text-center w-48">
                    <p class="text-sm text-slate-600 mb-20 font-inter">Diserahkan Oleh,</p>
                    <div class="border-b border-brand-900 mx-auto w-40"></div>
                    <p class="text-brand-900 font-bold font-outfit mt-2">{{ Auth::user()->name ?? 'Kasir Toko' }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role ?? '' }}</p>
                </div>
                
                <div class="text-center w-48">
                    <p class="text-sm text-slate-600 mb-20 font-inter">Diterima Oleh,</p>
                    <div class="border-b border-brand-900 mx-auto w-40"></div>
                    <p class="text-brand-900 font-bold font-outfit mt-2">Admin Pusat</p>
                </div>
            </div>

            <!-- Print Footer text -->
            <div class="mt-16 text-center text-xs text-slate-400 font-inter hidden print:block border-t border-brand-100 pt-4">
                Dicetak oleh {{ Auth::user()->name ?? '-' }} ({{ Auth::user()->role ?? '-' }}) pada {{ date('d M Y H:i:s') }}
            </div>

        </main>
    </div>

</body>
</html>