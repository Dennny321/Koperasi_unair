<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #{{ $transaksi->no_nota ?? $transaksi->no_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        /* ===== NOTA WRAPPER ===== */
        .nota-container {
            background: white;
            width: 58mm; /* Ubah ke 80mm jika printer Anda 80mm */
            min-height: 100mm;
            padding: 3mm 2mm;
            box-shadow: 0 4px 20px rgba(0,0,0,.15);
            font-size: 8pt;
            margin: 0 auto;
        }

        /* HEADER */
        .nota-header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .nota-toko {
            font-size: 11pt;
            font-weight: 900;
            letter-spacing: 0.5px;
        }
        .nota-sub {
            font-size: 7pt;
            color: #555;
            margin-top: 2px;
        }
        .nota-alamat {
            font-size: 6.5pt;
            color: #555;
            margin-top: 2px;
        }

        /* INFO NOTA */
        .nota-info {
            margin-bottom: 6px;
            border-bottom: 1px dashed #333;
            padding-bottom: 4px;
        }
        .nota-info-row {
            display: flex;
            justify-content: space-between;
            font-size: 7.5pt;
            margin-bottom: 2px;
        }
        .nota-info-row .label {
            color: #555;
        }
        .nota-info-row .value {
            font-weight: 700;
            text-align: right;
            max-width: 35mm;
            word-wrap: break-word;
        }

        .nota-nomor-surat {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 4px 6px;
            text-align: center;
            margin-bottom: 6px;
        }
        .nota-nomor-surat .label {
            font-size: 6pt;
            color: #888;
            letter-spacing: .3px;
            text-transform: uppercase;
        }
        .nota-nomor-surat .value {
            font-size: 9pt;
            font-weight: 900;
            color: #2f3291;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        /* ITEMS */
        .nota-items {
            margin-bottom: 6px;
        }
        .nota-item {
            padding: 2px 0;
            border-bottom: 1px dotted #ddd;
        }
        .nota-item:last-child {
            border-bottom: none;
        }
        .nota-item-nama {
            font-weight: 700;
            font-size: 8pt;
            word-wrap: break-word;
        }
        .nota-item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 7pt;
            color: #444;
            margin-top: 1px;
        }
        .nota-item-subtotal {
            font-weight: 700;
        }

        /* TOTAL */
        .nota-total {
            border-top: 1px dashed #333;
            padding-top: 4px;
            margin-bottom: 6px;
        }
        .nota-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 8pt;
            margin-bottom: 3px;
        }
        .nota-total-row.grand {
            font-size: 9pt;
            font-weight: 900;
            border-top: 1px solid #333;
            padding-top: 4px;
            margin-top: 4px;
        }
        .nota-total-row.grand .amount {
            color: #2f3291;
        }

        /* METODE */
        .nota-metode {
            text-align: center;
            background: #f0f4ff;
            border-radius: 3px;
            padding: 3px;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 8pt;
            color: #2f3291;
        }

        /* MEMBER */
        .nota-member {
            border-top: 1px dashed #333;
            padding-top: 4px;
            margin-bottom: 6px;
            font-size: 7.5pt;
        }
        .nota-member .label {
            color: #888;
            font-size: 6.5pt;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 2px;
        }
        .nota-member .nama {
            font-weight: 700;
        }
        .nota-member .poin {
            color: #f59e0b;
            font-weight: 700;
        }

        /* FOOTER */
        .nota-footer {
            border-top: 1px dashed #333;
            padding-top: 4px;
            text-align: center;
            font-size: 6.5pt;
            color: #888;
            line-height: 1.5;
        }

        /* TOMBOL AKSI (tidak ikut cetak) */
        .action-bar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        .btn-action {
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,.15);
            transition: all .2s;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }
        .btn-print {
            background: #2f3291;
            color: white;
        }
        .btn-print:hover {
            background: #1e2061;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(47,50,145,.3);
        }
        .btn-close {
            background: white;
            color: #333;
            border: 1px solid #ddd;
        }
        .btn-close:hover {
            background: #f4f7fe;
        }

        /* ===== PRINT STYLES ===== */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                width: 58mm; /* Ubah ke 80mm jika printer Anda 80mm */
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
            }

            body {
                background: white !important;
            }

            .nota-container {
                box-shadow: none !important;
                width: 58mm !important; /* Ubah ke 80mm jika printer Anda 80mm */
                margin: 0 !important;
                padding: 2mm 1mm !important;
                page-break-after: avoid;
            }

            .action-bar {
                display: none !important;
            }

            /* Pastikan warna tetap muncul saat print */
            .nota-nomor-surat {
                background: #f9f9f9 !important;
                border: 1px solid #ddd !important;
            }

            .nota-metode {
                background: #f0f4ff !important;
            }

            .nota-total-row.grand .amount {
                color: #2f3291 !important;
            }

            .nota-member .poin {
                color: #f59e0b !important;
            }
        }

        @page {
            size: auto; /* Biarkan auto karena tidak ada custom size */
            margin: 0;
        }
    </style>
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:700,800&display=swap" rel="stylesheet">
</head>
<body>

    <!-- NOTA CETAK -->
    <div class="nota-container" id="nota">

        <!-- HEADER -->
        <div class="nota-header">
            <div class="nota-toko">KOPERASI UNAIR</div>
            <div class="nota-sub">Koperasi Pegawai Universitas Airlangga</div>
            <div class="nota-alamat">Kampus B Unair, Surabaya</div>
        </div>

        <!-- NOMOR SURAT JALAN / NOTA -->
        <div class="nota-nomor-surat">
            <div class="label">No. Nota / Surat Jalan</div>
            <div class="value">{{ $transaksi->no_nota ?? $transaksi->no_transaksi }}</div>
        </div>

        <!-- INFO TRANSAKSI -->
        <div class="nota-info">
            <div class="nota-info-row">
                <span class="label">No. Transaksi</span>
                <span class="value">{{ $transaksi->no_transaksi }}</span>
            </div>
            <div class="nota-info-row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $transaksi->dibuat_pada->format('d/m/Y H:i') }}</span>
            </div>
            <div class="nota-info-row">
                <span class="label">Kasir</span>
                <span class="value">{{ $transaksi->kasir?->name ?? '-' }}</span>
            </div>
        </div>

        <!-- ITEM BELANJA -->
        <div class="nota-items">
            @foreach($transaksi->detail as $item)
            <div class="nota-item">
                <div class="nota-item-nama">{{ $item->produk?->nama ?? 'Produk' }}</div>
                <div class="nota-item-detail">
                    <span>{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                    <span class="nota-item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- TOTAL -->
        <div class="nota-total">
            <div class="nota-total-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="nota-total-row grand">
                <span>TOTAL</span>
                <span class="amount">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="nota-total-row" style="margin-top:3px;">
                <span>Dibayar</span>
                <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="nota-total-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- METODE BAYAR -->
        <div class="nota-metode">
            @php
                $metodeLbl = ['tunai' => '💵 TUNAI', 'transfer' => '🏦 TRANSFER', 'qris' => '📱 QRIS'];
            @endphp
            {{ $metodeLbl[$transaksi->metode_bayar] ?? strtoupper($transaksi->metode_bayar) }}
        </div>

        <!-- INFO MEMBER + POIN (jika ada) -->
        @if($transaksi->member)
        <div class="nota-member">
            <div class="label">Member</div>
            <div class="nama">{{ $transaksi->member->name }}</div>
            <div>{{ $transaksi->member->no_telepon }}</div>
            @if($transaksi->riwayatPoin)
            <div class="poin" style="margin-top:3px;">
                ⭐ +{{ number_format($transaksi->riwayatPoin->poin, 0, ',', '.') }} poin diberikan
            </div>
            @endif
        </div>
        @endif

        <!-- FOOTER -->
        <div class="nota-footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Barang yang sudah dibeli</p>
            <p>tidak dapat dikembalikan.</p>
            <p style="margin-top:4px; font-size:6pt; color:#bbb;">
                Dicetak: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="action-bar">
        <button class="btn-action btn-close" onclick="window.close()">
            <span>✕</span> Tutup
        </button>
        <button class="btn-action btn-print" onclick="printNota()">
            <span>🖨️</span> Cetak Nota
        </button>
    </div>

    <script>
        function printNota() {
            window.print();
        }

        // Auto print jika dibuka dari window baru
        if (window.opener || window.name === 'notaWindow') {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                }, 800);
            });
        }

        // Deteksi setelah print selesai (opsional)
        window.addEventListener('afterprint', function() {
            console.log('Print selesai atau dibatalkan');
        });
    </script>
</body>
</html>