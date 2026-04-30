<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->invoice_number }} - Toko Kain Nelly</title>
    <style>
        /* ══════════════════════════════════════════════
           BASE STYLES — Tampilan di browser
        ══════════════════════════════════════════════ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f1f5f9;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 24px 12px 48px;
        }

        /* Action buttons — hanya tampil di browser, hilang saat print */
        .action-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 360px;
        }

        .btn {
            flex: 1;
            padding: 10px 16px;
            border-radius: 10px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            text-decoration: none;
            text-align: center;
        }

        .btn-print {
            background: #1e3a5f;
            color: white;
        }

        .btn-print:hover { background: #162d4a; }

        .btn-back {
            background: white;
            color: #475569;
            border: 1.5px solid #e2e8f0;
        }

        .btn-back:hover { background: #f8fafc; }

        /* ══════════════════════════════════════════════
           STRUK / RECEIPT CARD
        ══════════════════════════════════════════════ */
        .receipt {
            width: 100%;
            max-width: 360px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 24px 20px;
            font-size: 13px;
            line-height: 1.5;
            color: #111;
        }

        /* Header toko */
        .receipt-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .receipt-header .store-name {
            font-size: 17px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .receipt-header .store-branch {
            font-size: 12px;
            margin-top: 2px;
        }

        .receipt-header .store-address {
            font-size: 11px;
            color: #555;
            margin-top: 3px;
        }

        /* Garis pemisah */
        .divider {
            border: none;
            border-top: 1px dashed #999;
            margin: 10px 0;
        }

        /* Info transaksi */
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin: 3px 0;
        }

        .info-row .label { color: #555; }
        .info-row .value { font-weight: 600; text-align: right; max-width: 60%; }

        /* Tabel item */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 8px 0;
        }

        .items-table th {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #777;
            padding: 4px 0;
            border-bottom: 1px dashed #ccc;
        }

        .items-table th:last-child,
        .items-table td:last-child {
            text-align: right;
        }

        .items-table td {
            padding: 6px 0;
            vertical-align: top;
            border-bottom: 1px dotted #eee;
        }

        .items-table .item-name {
            font-weight: 700;
            font-size: 12px;
        }

        .items-table .item-variant {
            font-size: 10px;
            color: #666;
        }

        .items-table .item-qty {
            text-align: center;
            white-space: nowrap;
        }

        .items-table .item-subtotal {
            font-weight: 600;
            white-space: nowrap;
        }

        /* Total */
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 8px;
        }

        .total-label {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 900;
        }

        /* Payment info */
        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 6px;
            color: #555;
        }

        /* Footer */
        .receipt-footer {
            text-align: center;
            font-size: 12px;
            margin-top: 14px;
            color: #333;
        }

        .receipt-footer .thank-you {
            font-size: 13px;
            font-weight: 700;
        }

        .receipt-footer .tagline {
            font-size: 11px;
            color: #777;
            margin-top: 3px;
        }

        /* ══════════════════════════════════════════════
           PRINT STYLES — Thermal 80mm
        ══════════════════════════════════════════════ */
        @media print {
            @page {
                size: 80mm auto;
                margin: 4mm 2mm;
            }

            body {
                background: white;
                padding: 0;
            }

            /* Sembunyikan tombol saat print */
            .action-bar {
                display: none !important;
            }

            .receipt {
                max-width: 80mm;
                width: 80mm;
                box-shadow: none;
                border-radius: 0;
                padding: 0 2mm;
                font-size: 11px;
            }

            .receipt-header .store-name {
                font-size: 14px;
            }

            .total-amount {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    {{-- ── Action Buttons (hanya tampil di browser) ── --}}
    <div class="action-bar">
        <button class="btn btn-print" onclick="window.print()" id="btn_cetak_ulang">
            🖨 Cetak Ulang
        </button>
        <a href="{{ route('pos') }}" class="btn btn-back" id="btn_kembali_kasir">
            ← Kembali ke Kasir
        </a>
    </div>

    {{-- ── Struk ── --}}
    <div class="receipt" id="struk_receipt">

        {{-- Header --}}
        <div class="receipt-header">
            <div class="store-name">Toko Kain Nelly</div>
            <div class="store-branch">Cabang Kepanjen</div>
            <div class="store-address">Jl. Panji No.123, Kepanjen, Malang</div>
            <div class="store-address">Telp: (0341) 000-0000</div>
        </div>

        <hr class="divider">

        {{-- Info Transaksi --}}
        <div class="info-row">
            <span class="label">No. Nota</span>
            <span class="value">{{ $order->invoice_number }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tanggal</span>
            <span class="value">{{ $order->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Pukul</span>
            <span class="value">{{ $order->created_at->format('H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Kasir</span>
            <span class="value">{{ $order->user->name ?? 'Admin' }}</span>
        </div>

        <hr class="divider">

        {{-- Tabel Item --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="text-align:left; width:45%">Produk</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Harga</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <div class="item-name">{{ $item->productVariant->product->name ?? '-' }}</div>
                            <div class="item-variant">{{ $item->productVariant->color_name ?? '' }}</div>
                        </td>
                        <td class="item-qty">{{ number_format($item->quantity, 1, ',', '.') }}m</td>
                        <td style="text-align:right; white-space:nowrap;">{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="item-subtotal">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="divider">

        {{-- Total --}}
        <div class="total-row">
            <span class="total-label">Total Bayar</span>
            <span class="total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>

        <div class="payment-row">
            <span>Metode Pembayaran</span>
            <span style="font-weight:600; text-transform:uppercase;">{{ $order->payment_method ?? 'Tunai' }}</span>
        </div>

        <hr class="divider">

        {{-- Footer --}}
        <div class="receipt-footer">
            <div class="thank-you">Terima Kasih Atas Kunjungan Anda!</div>
            <div class="tagline">Semoga puas dengan belanja Anda di Toko Kain Nelly</div>
        </div>

    </div>

    <script>
        // Auto-print dengan delay agar halaman sempurna ter-render
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 500);
        });
    </script>

</body>
</html>
