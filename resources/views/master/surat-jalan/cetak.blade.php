<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan {{ $suratJalan->no_surat }}</title>
    @php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
            color: #1a1a2e;
        }

        /* ===== DOKUMEN WRAPPER ===== */
        .dokumen {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 16mm 15mm 12mm;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.18);
            position: relative;
            display: flex;
            /* ← tambah */
            flex-direction: column;
            /* ← tambah */
        }

        /* ===== KOPERASI HEADER ===== */
        .kop-surat {
            padding-bottom: 10px;
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kop-nama-koperasi {
            font-size: 20pt;
            font-weight: 900;
            color: #2f3291;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .kop-sub {
            font-size: 9pt;
            color: #555;
            margin-top: 2px;
        }

        .kop-alamat {
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
            line-height: 1.5;
        }

        .kop-logo-placeholder {
            width: 60px;
            height: 60px;
            background: #2f3291;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22pt;
            font-weight: 900;
            flex-shrink: 0;
        }

        /* ===== JUDUL DOKUMEN ===== */
        .judul-dokumen {
            text-align: center;
            margin: 12px 0 18px;
        }

        .judul-dokumen h1 {
            font-size: 16pt;
            font-weight: 900;
            color: #2f3291;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .judul-dokumen .nomor-surat {
            display: inline-block;
            background: #f0f4ff;
            border: 1.5px solid #2f3291;
            border-radius: 6px;
            padding: 5px 20px;
            font-size: 11pt;
            font-weight: 800;
            color: #2f3291;
            margin-top: 6px;
            letter-spacing: 1px;
        }

        /* ===== INFO SURAT ===== */
        .info-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin-bottom: 18px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .info-row {
            display: flex;
            padding: 6px 12px;
            border-bottom: 1px solid #eee;
            font-size: 9pt;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 110px;
            color: #666;
            flex-shrink: 0;
            font-weight: 600;
        }

        .info-value {
            font-weight: 700;
            color: #1a1a2e;
        }

        .info-col-left {
            border-right: 1.5px solid #ddd;
        }

        .info-col-right {}

        /* ===== TABEL BARANG ===== */
        .tabel-barang {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9.5pt;
        }

        .tabel-barang thead tr {
            background: #2f3291;
            color: white;
        }

        .tabel-barang th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 700;
            font-size: 9pt;
            letter-spacing: 0.3px;
        }

        .tabel-barang th.text-center {
            text-align: center;
        }

        .tabel-barang th.text-right {
            text-align: right;
        }

        .tabel-barang tbody tr:nth-child(even) {
            background: #f8faff;
        }

        .tabel-barang td {
            padding: 7px 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .tabel-barang td.text-center {
            text-align: center;
        }

        .tabel-barang td.text-right {
            text-align: right;
        }

        .tabel-barang tfoot tr {
            background: #f0f4ff;
        }

        .tabel-barang tfoot td {
            padding: 8px 10px;
            font-weight: 800;
            border-top: 2px solid #2f3291;
            font-size: 10pt;
        }

        /* ===== KETERANGAN ===== */
        .keterangan-box {
            border: 1.5px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 24px;
            font-size: 9pt;
            color: #444;
        }

        .keterangan-box .label {
            font-weight: 800;
            font-size: 8pt;
            color: #2f3291;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .ttd-box {
            text-align: center;

            border-radius: 8px;
            padding: 12px 10px 10px;
        }

        .ttd-title {
            font-size: 8.5pt;
            font-weight: 800;
            color: #2f3291;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .ttd-subtitle {
            font-size: 7.5pt;
            color: #888;
            margin-bottom: 60px;
            /* ruang tanda tangan */
        }

        .ttd-garis {
            /* border-top: 1.5px solid #333; */
            margin: 0 10px;
        }

        .ttd-nama {
            font-size: 8.5pt;
            font-weight: 800;
            margin-top: 5px;
            color: #1a1a2e;
        }

        .ttd-jabatan {
            font-size: 7.5pt;
            color: #666;
            margin-top: 2px;
        }

        /* ===== STEMPEL AREA ===== */
        .stempel-note {
            font-size: 7.5pt;
            color: #aaa;
            text-align: center;
            margin-top: 6px;
            font-style: italic;
        }

        /* ===== FOOTER DOKUMEN ===== */
        .footer-dok {
            margin-top: 16px;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
            font-size: 7.5pt;
            color: #aaa;
        }

        /* ===== STATUS WATERMARK (hanya di screen) ===== */
        @media screen {
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-30deg);
                font-size: 80pt;
                font-weight: 900;
                opacity: 0.04;
                color: #2f3291;
                pointer-events: none;
                white-space: nowrap;
                z-index: 0;
            }
        }

        /* ===== TOMBOL AKSI (tidak dicetak) ===== */
        .action-bar {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 999;
        }

        .btn-action {
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print {
            background: #2f3291;
            color: white;
        }

        .btn-back {
            background: white;
            color: #2f3291;
            border: 2px solid #2f3291;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .dokumen {
                box-shadow: none;
                width: 100%;
                padding: 10mm 12mm;
            }

            .action-bar {
                display: none !important;
            }

            .watermark {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    {{-- Watermark status (screen only) --}}
    @if ($suratJalan->status === 'draft')
        <div class="watermark">DRAFT</div>
    @endif

    <div class="dokumen">

        {{-- ===== KOP SURAT ===== --}}
        <div class="kop-surat" style="padding-bottom:0; display:block;">
            <img src="{{ Vite::asset('resources/images/kop-surat.jpg') }}" alt="Kop Surat Koperasi UNAIR"
                style="width:100%; height:120px; display:block;">
        </div>

        {{-- ===== JUDUL ===== --}}
        <div class="judul-dokumen">
            <h1>Surat Jalan / Invoice</h1>
            <div class="nomor-surat">{{ $suratJalan->no_surat }}</div>
        </div>

        {{-- ===== INFO BOX ===== --}}
        <div class="info-box">
            <div class="info-col-left">
                <div class="info-row">
                    <span class="info-label">No. Surat</span>
                    <span class="info-value">{{ $suratJalan->no_surat }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Transaksi</span>
                    <span class="info-value" style="font-size:8pt;">{{ $suratJalan->no_transaksi }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal</span>
                    <span class="info-value">{{ $suratJalan->created_at->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Waktu</span>
                    <span class="info-value">{{ $suratJalan->created_at->format('H:i') }} WIB</span>
                </div>
            </div>
            <div class="info-col-right">
                <div class="info-row">
                    <span class="info-label">Tujuan</span>
                    <span class="info-value">{{ $suratJalan->tujuan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Dibuat oleh</span>
                    <span class="info-value">{{ $suratJalan->kasir?->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">{{ strtoupper($suratJalan->status) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Halaman</span>
                    <span class="info-value">1 / 1</span>
                </div>
            </div>
        </div>

        {{-- ===== TABEL BARANG ===== --}}
        <table class="tabel-barang">
            <thead>
                <tr>
                    <th style="width:30px;">No</th>
                    <th style="width:80px;">Kode</th>
                    <th>Nama Barang</th>
                    <th class="text-center" style="width:60px;">Qty</th>
                    <th style="width:50px;">Satuan</th>
                    <th class="text-right" style="width:110px;">Harga Satuan</th>
                    <th class="text-right" style="width:120px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratJalan->detail as $i => $d)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td><code style="font-size:8pt;">{{ $d->produk?->kode_produk ?? '—' }}</code></td>
                        <td>
                            <strong>{{ $d->produk?->nama ?? 'Produk tidak ditemukan' }}</strong>
                            @if ($d->produk?->keterangan)
                                <br><small
                                    style="color:#888; font-size:7.5pt;">{{ Str::limit($d->produk->keterangan, 60) }}</small>
                            @endif
                        </td>
                        <td class="text-center"><strong>{{ $d->jumlah }}</strong></td>
                        <td style="color:#666; font-size:8.5pt;">{{ $d->produk?->satuan ?? 'pcs' }}</td>
                        <td class="text-right">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right" style="color:#2f3291;">TOTAL KESELURUHAN</td>
                    <td class="text-right" style="color:#2f3291; font-size:12pt;">
                        Rp {{ number_format($suratJalan->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        {{-- ===== KETERANGAN ===== --}}
        @if ($suratJalan->keterangan)
            <div class="keterangan-box">
                <div class="label">Keterangan</div>
                <div>{{ $suratJalan->keterangan }}</div>
            </div>
        @endif

        {{-- ===== AREA TANDA TANGAN ===== --}}
        <div class="ttd-section" style="display:flex; justify-content:space-between; gap:20px;">
            <div class="ttd-box" style="width:200px;">
                <div class="ttd-title">Disetujui oleh</div>
                <div class="ttd-subtitle"></div>
                <div class="ttd-garis"></div>
                <div class="ttd-nama">_______________</div>
                <div class="ttd-jabatan"></div>
                <div class="stempel-note"></div>
            </div>

            <div class="ttd-box" style="width:200px;">
                <div class="ttd-title">Diterima oleh</div>
                <div class="ttd-subtitle"></div>
                <div class="ttd-garis"></div>
                <div class="ttd-nama">_______________</div>
                <div class="ttd-jabatan"></div>
                <div class="stempel-note"></div>
            </div>
        </div>

        {{-- ===== FOOTER ===== --}}
        {{-- <div class="footer-dok">
            <span>Dicetak: {{ now()->format('d/m/Y H:i') }} WIB &bull; Sistem Koperasi Pegawai UNAIR</span>
            <span>{{ $suratJalan->no_surat }} &bull; Halaman 1</span>
        </div> --}}

    </div>

    {{-- ===== TOMBOL AKSI (tidak ikut cetak) ===== --}}
    <div class="action-bar">
        <a href="{{ route($rp . '.surat-jalan.show', $suratJalan) }}" class="btn-action btn-back">
            ← Kembali
        </a>
        <button class="btn-action btn-print" onclick="window.print()">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <script>
        // Auto print dialog saat halaman dibuka (opsional — hapus jika tidak diinginkan)
        // window.addEventListener('load', () => window.print());
    </script>
</body>

</html>
