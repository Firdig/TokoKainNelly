<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picking Slip - {{ $order->invoice_number }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { font-family: 'Inter', sans-serif; background: white; }
            .no-print { display: none !important; }
            .print-border { border: 2px solid #000; }
        }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #0f172a; }
    </style>
</head>
<body class="p-8">
    
    <div class="max-w-3xl mx-auto bg-white p-8 print-border shadow-sm print:shadow-none min-h-[800px] border border-slate-200 relative">
        <!-- Print Action -->
        <div class="absolute top-4 right-4 no-print flex gap-2">
            <button onclick="window.print()" class="bg-brand-600 hover:bg-brand-900 text-white px-4 py-2 rounded-lg font-bold text-sm shadow-md transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Slip
            </button>
            <a href="{{ url('/admin/orders') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded-lg font-bold text-sm transition-all">Tutup</a>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-6 mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-16 h-16 object-cover rounded-lg grayscale print:grayscale-0">
                <div>
                    <h1 class="text-3xl font-black font-outfit uppercase tracking-wider">PICKING SLIP</h1>
                    <p class="text-sm font-bold text-slate-600">Toko Kain Nelly - Panjen</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold uppercase tracking-widest border-2 border-slate-900 px-3 py-1 inline-block bg-slate-100">
                    {{ $order->transaction_type == 'bops' ? 'BOPS' : 'DELIVERY' }}
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
            <div>
                <table class="w-full">
                    <tr><td class="text-slate-500 py-1 w-32">No. Invoice</td><td class="font-bold text-lg">{{ $order->invoice_number }}</td></tr>
                    <tr><td class="text-slate-500 py-1">Tanggal Pesan</td><td class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</td></tr>
                    <tr><td class="text-slate-500 py-1">Dicetak Tgl</td><td class="font-medium">{{ now()->format('d M Y, H:i') }}</td></tr>
                </table>
            </div>
            <div>
                <div class="border-l-4 border-slate-200 pl-4 h-full">
                    <p class="text-slate-500 mb-1">Informasi Pelanggan:</p>
                    <p class="font-bold text-base">{{ $order->customer_name ?? ($order->user->name ?? 'Pelanggan') }}</p>
                    <p class="font-medium">{{ $order->customer_phone ?? '-' }}</p>
                    
                    @if($order->transaction_type == 'bops')
                        <div class="mt-4 p-3 bg-slate-100 border border-slate-300 rounded">
                            <p class="text-xs text-slate-500 uppercase font-bold">Est. Pengambilan:</p>
                            <p class="font-bold">{{ $order->estimated_pickup_at ? $order->estimated_pickup_at->format('d M Y, H:i') : '-' }}</p>
                        </div>
                    @else
                        <p class="mt-2 text-xs text-slate-500 uppercase font-bold">Alamat Pengiriman:</p>
                        <p class="font-medium">{{ $order->delivery_address ?? '-' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="w-full mb-8 border border-slate-900">
            <thead class="bg-slate-100 border-b border-slate-900">
                <tr>
                    <th class="p-3 text-left border-r border-slate-900 w-12">No</th>
                    <th class="p-3 text-left border-r border-slate-900">Nama Barang / Kain</th>
                    <th class="p-3 text-left border-r border-slate-900 w-32">Warna/Varian</th>
                    <th class="p-3 text-center border-r border-slate-900 w-24">Qty</th>
                    <th class="p-3 text-center w-24 text-xs">Check</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr class="border-b border-slate-300">
                    <td class="p-3 border-r border-slate-900 text-center font-bold">{{ $index + 1 }}</td>
                    <td class="p-3 border-r border-slate-900 font-bold text-lg uppercase">{{ $item->productVariant->product->name ?? 'Produk' }}</td>
                    <td class="p-3 border-r border-slate-900 font-medium">{{ $item->productVariant->color_name ?? '-' }}</td>
                    <td class="p-3 border-r border-slate-900 text-center font-black text-xl">{{ $item->quantity }}<span class="text-sm font-normal ml-1">m</span></td>
                    <td class="p-3 text-center align-middle">
                        <div class="w-8 h-8 border-2 border-slate-400 mx-auto rounded"></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="flex justify-between items-end mt-16 px-12">
            <div class="text-center">
                <p class="text-sm text-slate-500 mb-12">Disiapkan Oleh (Picker)</p>
                <div class="border-b border-slate-900 w-40 mx-auto mb-2"></div>
                <p class="text-xs font-bold">{{ Auth::user()->name ?? 'Admin / Staff' }}</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-slate-500 mb-12">Diverifikasi Oleh (Checker)</p>
                <div class="border-b border-slate-900 w-40 mx-auto mb-2"></div>
                <p class="text-xs font-bold">.........................................</p>
            </div>
        </div>

    </div>

</body>
</html>
