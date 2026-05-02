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
        .status-box { border-radius: 12px; padding: 24px; margin: 20px 0; text-align: center; }
        .status-ready { background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; }
        .status-shipped { background: linear-gradient(135deg, #4f46e5, #6366f1); color: white; }
        .status-completed { background: linear-gradient(135deg, #16a34a, #22c55e); color: white; }
        .status-cancelled { background: linear-gradient(135deg, #dc2626, #ef4444); color: white; }
        .status-default { background: linear-gradient(135deg, #7d621e, #c9a54a); color: white; }
        .pickup-code { font-size: 32px; letter-spacing: 8px; font-weight: bold; margin: 12px 0; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .footer { text-align: center; padding: 24px 0; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Toko Kain Nelly</div>
            <p style="color: #94a3b8; margin-top: 4px;">Pembaruan Status Pesanan</p>
        </div>

        <div class="card">
            @php
                $statusLabels = [
                    'pending'           => 'Menunggu Konfirmasi',
                    'in_preparation'    => 'Sedang Diproses',
                    'ready_for_pickup'  => 'Siap Diambil di Toko',
                    'shipped'           => 'Sedang Dikirim',
                    'completed'         => 'Pesanan Selesai',
                    'cancelled'         => 'Pesanan Dibatalkan',
                ];
                $statusClass = match($newStatus) {
                    'ready_for_pickup'  => 'status-ready',
                    'shipped'           => 'status-shipped',
                    'completed'         => 'status-completed',
                    'cancelled'         => 'status-cancelled',
                    default             => 'status-default',
                };
                $statusMessages = [
                    'in_preparation'    => 'Pesanan Anda sedang diproses oleh tim kami. Kami akan segera mempersiapkan kain pilihan Anda.',
                    'ready_for_pickup'  => 'Pesanan Anda sudah siap! Silakan datang ke toko untuk mengambil pesanan dengan menunjukkan kode pengambilan.',
                    'shipped'           => 'Pesanan Anda sudah dikirim dan sedang dalam perjalanan ke alamat tujuan.',
                    'completed'         => 'Pesanan Anda telah selesai. Terima kasih telah berbelanja di Toko Kain Nelly!',
                    'cancelled'         => 'Pesanan Anda telah dibatalkan. Jika Anda memiliki pertanyaan, silakan hubungi kami.',
                ];
            @endphp

            <h2 style="margin-top:0;">Halo, {{ $order->customer_name ?? 'Pelanggan' }}!</h2>
            <p>Status pesanan Anda telah diperbarui:</p>

            <div class="status-box {{ $statusClass }}">
                <p style="margin:0; opacity: 0.9; font-size: 14px;">Status Terbaru</p>
                <p style="margin: 8px 0 0; font-size: 22px; font-weight: bold;">{{ $statusLabels[$newStatus] ?? ucfirst($newStatus) }}</p>
            </div>

            <p>{{ $statusMessages[$newStatus] ?? 'Status pesanan Anda telah diperbarui.' }}</p>

            @if($newStatus === 'ready_for_pickup' && $isBops && $order->pickup_code)
            <div style="background: linear-gradient(135deg, #7d621e, #c9a54a); color: white; border-radius: 12px; padding: 24px; margin: 20px 0; text-align: center;">
                <p style="margin:0; opacity: 0.9;">Kode Pengambilan Anda</p>
                <div class="pickup-code">{{ $order->pickup_code }}</div>
                <p style="margin:0; font-size: 14px; opacity: 0.8;">Tunjukkan kode ini kepada kasir saat mengambil kain di toko.</p>
            </div>
            @endif

            <h3 style="margin-top: 24px;">Informasi Pesanan</h3>
            <div style="padding:10px 0; border-bottom:1px solid #f1f5f9;">
                <span style="color: #64748b;">Nomor Invoice</span><br>
                <strong>{{ $order->invoice_number }}</strong>
            </div>
            <div style="padding:10px 0; border-bottom:1px solid #f1f5f9;">
                <span style="color: #64748b;">Tipe Pesanan</span><br>
                <strong>{{ $isBops ? 'Ambil di Toko (BOPS)' : 'Pengiriman' }}</strong>
            </div>
            <div style="padding:10px 0;">
                <span style="color: #64748b;">Total</span><br>
                <strong style="font-size: 20px; color: #9a7925;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
            </div>

            <div style="margin-top: 24px; padding: 16px; background: #faf8f2; border-radius: 12px; text-align: center;">
                <p style="margin: 0; font-size: 14px; color: #64748b;">
                    Anda dapat melacak pesanan Anda kapan saja di halaman <strong>Pesanan Saya</strong> pada website kami.
                </p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Toko Kain Nelly Panjen. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
