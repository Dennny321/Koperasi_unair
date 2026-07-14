<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Koperasi Pegawai UNAIR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a202c;
            background: #fff;
        }

        .page-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* ── HEADER ── */
        .kop {
            padding: 20px 0 16px;
        }

        .kop-logo {
            width: 64px;
            height: 64px;
            border: 2px solid #2f3291;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 900;
            color: #2f3291;
            flex-shrink: 0;
        }

        .kop-info h1 {
            font-size: 18px;
            font-weight: 800;
            color: #2f3291;
            margin-bottom: 2px;
        }

        .kop-info p {
            font-size: 11px;
            color: #4a5568;
        }

        .report-title {
            padding: 14px 32px 10px;
            background: #2f3291;
            color: #fff;
        }

        .report-title h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .report-title p {
            font-size: 11px;
            opacity: .8;
        }

        .meta-bar {
            display: flex;
            gap: 0;
            background: #f7f8ff;
            border-bottom: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }

        .meta-item {
            flex: 1;
            min-width: 180px;
            padding: 6px 16px 6px 0;
        }

        .meta-item label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #718096;
            display: block;
            margin-bottom: 2px;
        }

        .meta-item span {
            font-size: 12px;
            font-weight: 600;
            color: #2d3748;
        }

        /* ── SUMMARY ── */
        .summary-bar {
            display: flex;
            gap: 0;
        }

        .summary-item {
            flex: 1;
            padding: 14px 20px;
            margin: 12px 8px 0 0;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .summary-item:last-child {
            margin-right: 0;
        }

        .summary-item label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #718096;
            display: block;
            margin-bottom: 4px;
        }

        .summary-item span {
            font-size: 18px;
            font-weight: 800;
            color: #2f3291;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: #2f3291;
            color: #fff;
        }

        thead th {
            padding: 10px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        thead th.right {
            text-align: right;
        }

        thead th.center {
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f7f8ff;
        }

        tbody tr:hover {
            background: #eef0ff;
        }

        tbody td {
            padding: 9px 10px;
            font-size: 11.5px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: top;
        }

        tbody td.right {
            text-align: right;
        }

        tbody td.center {
            text-align: center;
        }

        .no-transaksi {
            font-weight: 700;
            color: #2f3291;
            font-size: 11px;
        }

        .sub-text {
            font-size: 10px;
            color: #718096;
        }

        /* Detail baris produk */
        .produk-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .produk-list li {
            padding: 1px 0;
            font-size: 11px;
            color: #4a5568;
        }

        .produk-list li::before {
            content: '• ';
            color: #2f3291;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .badge-tunai {
            background: #d1fae5;
            color: #059669;
        }

        .badge-transfer {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-qris {
            background: #ede9fe;
            color: #7c3aed;
        }

        /* ── FOOTER SUMMARY ROW ── */
        tfoot tr.total-row td {
            padding: 11px 10px;
            font-weight: 800;
            font-size: 13px;
            background: #2f3291;
            color: #fff;
            border: none;
        }

        /* ── FOOTER PAGE ── */
        .page-footer {
            border-top: 2px solid #2f3291;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #718096;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            thead {
                display: table-header-group;
            }
        }
    </style>
</head>

<body>
    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ Vite::asset('resources/images/kop-surat.jpg') }}" alt="Kop Surat Koperasi UNAIR"
            style="width:100%; height:200px; display:block;">
    </div>
    <div class="page-wrapper">

        <div class="report-title">
            <h2>LAPORAN PENJUALAN</h2>
            <p>Filter: {{ $filterLabel }}</p>
        </div>

        {{-- META --}}
        <div class="meta-bar">
            <div class="meta-item">
                <label>Dicetak Oleh</label>
                <span>{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
            <div class="meta-item">
                <label>Tanggal Cetak</label>
                <span>{{ now()->format('d M Y, H:i') }}</span>
            </div>
            <div class="meta-item">
                <label>Total Data</label>
                <span>{{ $transaksi->count() }} transaksi</span>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="summary-bar">
            <div class="summary-item">
                <label>Total Transaksi</label>
                <span>{{ number_format($summary['total_transaksi']) }}</span>
            </div>
            <div class="summary-item">
                <label>Total Pendapatan</label>
                <span style="font-size:15px;">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <label>Total Dibayar</label>
                <span style="font-size:15px;">Rp {{ number_format($summary['total_bayar'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <label>Rata-rata / Transaksi</label>
                <span style="font-size:15px;">Rp {{ number_format($summary['rata_rata'], 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th style="width:30px;">No</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Member</th>
                        <th>Produk Dibeli</th>
                        <th class="center" style="width:70px;">Metode</th>
                        <th class="right">Total Harga</th>
                        <th class="right">Dibayar</th>
                        <th class="right">Kembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $i => $t)
                        <tr>
                            <td class="center">{{ $i + 1 }}</td>
                            <td>
                                <div class="no-transaksi">{{ $t->no_transaksi }}</div>
                                @if ($t->no_nota)
                                    <div class="sub-text">{{ $t->no_nota }}</div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $t->dibuat_pada?->format('d/m/Y') }}</div>
                                <div class="sub-text">{{ $t->dibuat_pada?->format('H:i') }}</div>
                            </td>
                            <td>{{ $t->kasir->name ?? '-' }}</td>
                            <td>{{ $t->member->name ?? 'Umum' }}</td>
                            <td>
                                <ul class="produk-list">
                                    @foreach ($t->detail as $d)
                                        <li>{{ $d->produk->nama ?? '-' }} <strong>×{{ $d->jumlah }}</strong></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="center">
                                @php $m = strtolower($t->metode_bayar); @endphp
                                <span class="badge badge-{{ $m }}">{{ ucfirst($m) }}</span>
                            </td>
                            <td class="right" style="font-weight:700;">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="right">
                                Rp {{ number_format($t->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="right">
                                Rp {{ number_format($t->kembalian, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center;padding:30px;color:#718096;">
                                Tidak ada data transaksi yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="7" style="text-align:right;">TOTAL</td>
                        <td class="right">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
                        <td class="right">Rp {{ number_format($summary['total_bayar'], 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="page-footer">
            <span>Koperasi Pegawai Universitas Airlangga &copy; {{ now()->year }}</span>
            <span>Dicetak: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>

        {{-- PRINT BUTTON (hilang saat print) --}}
        <div class="no-print" style="text-align:center;padding:20px;background:#f7f8ff;border-top:1px solid #e2e8f0;">
            <button onclick="window.print()"
                style="background:#2f3291;color:#fff;padding:12px 28px;border:none;border-radius:10px;
               font-size:15px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;">
                🖨️ Cetak / Simpan PDF
            </button>
            <button onclick="window.close()"
                style="background:#e2e8f0;color:#4a5568;padding:12px 24px;border:none;border-radius:10px;
               font-size:15px;font-weight:600;cursor:pointer;margin-left:10px;">
                ✕ Tutup
            </button>
        </div>
    </div>

    <script>
        // Auto-trigger print dialog setelah 800ms
        window.addEventListener('load', () => setTimeout(() => window.print(), 800));
    </script>
</body>

</html>
