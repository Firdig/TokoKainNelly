<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #1e293b; margin: 0; padding: 0; background: #faf8f2; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: white; border-radius: 16px; padding: 32px; margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .header { text-align: center; padding: 24px 0; }
        .logo { font-size: 24px; font-weight: bold; color: #3a3225; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-bops { background: #ede9fe; color: #7c3aed; }
        .badge-delivery { background: #f0ead8; color: #9a7925; }
        .item-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
        .total { font-size: 24px; font-weight: bold; color: #9a7925; text-align: right; margin-top: 16px; }
        .pickup-box { background: linear-gradient(135deg, #7d621e, #c9a54a); color: white; border-radius: 12px; padding: 24px; margin: 20px 0; text-align: center; }
        .pickup-code { font-size: 32px; letter-spacing: 8px; font-weight: bold; margin: 12px 0; }
        .footer { text-align: center; padding: 24px 0; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Toko Kain Nelly</div>
            <p style="color: #94a3b8; margin-top: 4px;">Konfirmasi Pesanan</p>
        </div>

        <div class="card">
            <h2 style="margin-top:0;">Terima kasih atas pesanan Anda!</h2>
            <p>Nomor Invoice: <strong>{{ $order->invoice_number }}</strong></p>
            <p>
                Tipe:
                <span class="badge {{ $isBops ? 'badge-bops' : 'badge-delivery' }}">
                    {{ $isBops ? 'Ambil di Toko (BOPS)' : 'Pengiriman' }}
                </span>
            </p>

            @if($isBops && $pickupCode)
            <div class="pickup-box">
                <p style="margin:0; opacity: 0.9;">Kode Pengambilan Anda</p>
                <div class="pickup-code">{{ $pickupCode }}</div>
                <p style="margin:0; font-size: 14px; opacity: 0.8;">Tunjukkan kode ini kepada kasir saat mengambil kain di toko.</p>
            </div>
            @endif

            <h3>Detail Pesanan</h3>
            @foreach($items as $item)
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f1f5f9;">
                <div>
                    <strong>{{ $item->productVariant->product->name ?? 'Produk' }}</strong><br>
                    <span style="color: #64748b; font-size: 13px;">{{ $item->productVariant->color_name ?? '' }} — {{ $item->quantity }}m</span>
                </div>
                <div style="font-weight:bold; white-space:nowrap;">
                    Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </div>
            </div>
            @endforeach

            <div class="total">Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Toko Kain Nelly Panjen. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
