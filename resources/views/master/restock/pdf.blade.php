<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Restock</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
        }

        /* ── HEADER ── */
        .header-table {
            width: 100%;
            background-color: #2E5EA8;
            padding: 14px 20px;
            margin-bottom: 14px;
        }
        .header-table td {
            color: #ffffff;
            vertical-align: top;
        }
        .header-left h1 {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .header-left p {
            font-size: 10px;
            opacity: 0.85;
        }
        .header-right {
            text-align: right;
            font-size: 10px;
        }
        .header-divider {
            width: 100%;
            border: none;
            border-top: 1px solid rgba(255,255,255,0.4);
            margin: 10px 0 8px 0;
        }
        .header-title {
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
        }
        .header-subtitle {
            font-size: 10px;
            color: #dce9f5;
            margin-top: 3px;
        }

        /* ── SUMMARY ── */
        .summary-table {
            width: 100%;
            margin: 0 0 14px 0;
            border-collapse: separate;
            border-spacing: 6px 0;
        }
        .summary-table td {
            width: 20%;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-left: 4px solid #4F81BD;
            padding: 9px 10px;
            vertical-align: top;
        }
        .summary-table td.green  { border-left-color: #28a745; }
        .summary-table td.orange { border-left-color: #fd7e14; }
        .summary-table td.red    { border-left-color: #dc3545; }
        .s-label {
            font-size: 8px;
            color: #888;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.4px;
        }
        .s-value {
            font-size: 15px;
            font-weight: bold;
            color: #222;
            margin-top: 3px;
        }
        .s-sub {
            font-size: 8px;
            color: #999;
            margin-top: 2px;
        }

        /* ── FILTER INFO ── */
        .filter-box {
            background-color: #fff8e1;
            border: 1px solid #ffe082;
            padding: 7px 12px;
            margin-bottom: 12px;
            font-size: 10px;
            color: #795548;
        }

        /* ── TABLE UTAMA ── */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        table.data-table thead tr {
            background-color: #4F81BD;
            color: #ffffff;
        }
        table.data-table thead th {
            padding: 8px 7px;
            border: 1px solid #3a6ca8;
            font-weight: bold;
            text-align: left;
        }
        table.data-table thead th.center { text-align: center; }
        table.data-table thead th.right  { text-align: right; }

        table.data-table tbody tr.even { background-color: #EBF3FB; }
        table.data-table tbody tr.odd  { background-color: #ffffff; }

        table.data-table tbody td {
            padding: 7px 7px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        table.data-table tbody td.center { text-align: center; }
        table.data-table tbody td.right  { text-align: right; }
        table.data-table tbody td.middle { vertical-align: middle; }

        /* Badges */
        .badge {
            padding: 2px 7px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-danger  { background-color: #f8d7da; color: #721c24; }
        .badge-info    { background-color: #d1ecf1; color: #0c5460; }

        /* Total row */
        table.data-table tfoot tr { background-color: #2E5EA8; color: #ffffff; }
        table.data-table tfoot td {
            padding: 8px 7px;
            border: 1px solid #1e4a8a;
            font-weight: bold;
        }

        /* ── DETAIL SUB-TABLE ── */
        .detail-wrapper {
            padding: 6px 0 4px 0;
        }
        .detail-label {
            font-size: 9px;
            font-weight: bold;
            color: #4F81BD;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        table.detail-table thead th {
            background-color: #D6E4F3;
            color: #1a3f6f;
            padding: 4px 6px;
            border: 1px solid #b8d0e8;
            font-weight: bold;
            text-align: left;
        }
        table.detail-table thead th.center { text-align: center; }
        table.detail-table thead th.right  { text-align: right; }
        table.detail-table tbody td {
            padding: 4px 6px;
            border: 1px solid #dde8f2;
            vertical-align: middle;
            background-color: #f5f9ff;
        }
        table.detail-table tbody td.center { text-align: center; }
        table.detail-table tbody td.right  { text-align: right; }
        table.detail-table tfoot td {
            padding: 4px 6px;
            border: 1px solid #b8d0e8;
            background-color: #c8ddf0;
            color: #1a3f6f;
            font-weight: bold;
            font-size: 9px;
        }
        table.detail-table tfoot td.right { text-align: right; }

        /* ── FOOTER ── */
        .footer-table {
            width: 100%;
            margin-top: 18px;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        .footer-table td { vertical-align: bottom; font-size: 9px; color: #888; }
        .sig-box { text-align: center; width: 160px; }
        .sig-line { border-bottom: 1px solid #aaa; margin: 36px 0 5px 0; }
        .sig-name { font-size: 9px; color: #444; font-weight: bold; }
        .sig-role { font-size: 9px; color: #aaa; }
    </style>
</head>
<body>

{{-- ── HEADER ── --}}
<table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
        <td class="header-left" width="65%">
            <h1>KOPERASI UNAIR</h1>
            <p>Laporan Data Restock Produk</p>
        </td>
        <td class="header-right" width="35%">
            <div>Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
            <div>Oleh: {{ auth()->user()->name ?? 'Admin' }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr class="header-divider">
            <div class="header-title">LAPORAN RESTOCK</div>
            <div class="header-subtitle">
                @if($filters['start_date'] && $filters['end_date'])
                    Periode: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}
                    s/d {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}
                @else
                    Semua Periode
                @endif
                @if($filters['status']) &nbsp;|&nbsp; Status: {{ ucfirst($filters['status']) }} @endif
                @if($filters['supplier_name']) &nbsp;|&nbsp; Supplier: {{ $filters['supplier_name'] }} @endif
            </div>
        </td>
    </tr>
</table>

{{-- ── SUMMARY ── --}}
<table class="summary-table" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="s-label">Total Restock</div>
            <div class="s-value">{{ $restocks->count() }}</div>
            <div class="s-sub">transaksi</div>
        </td>
        <td class="green">
            <div class="s-label">Total Nilai</div>
            <div class="s-value" style="font-size:12px;">Rp {{ number_format($restocks->sum('total_biaya'), 0, ',', '.') }}</div>
            <div class="s-sub">seluruh periode</div>
        </td>
        <td>
            <div class="s-label">Selesai</div>
            <div class="s-value">{{ $restocks->where('status','selesai')->count() }}</div>
            <div class="s-sub">approved</div>
        </td>
        <td class="orange">
            <div class="s-label">Draft</div>
            <div class="s-value">{{ $restocks->where('status','draft')->count() }}</div>
            <div class="s-sub">menunggu approval</div>
        </td>
        <td class="red">
            <div class="s-label">Dibatalkan</div>
            <div class="s-value">{{ $restocks->where('status','dibatalkan')->count() }}</div>
            <div class="s-sub">batal</div>
        </td>
    </tr>
</table>

{{-- ── FILTER INFO ── --}}
@if($filters['search'] || $filters['status'] || $filters['supplier_name'] || $filters['start_date'])
<div class="filter-box">
    <strong>Filter aktif:</strong>
    @if($filters['search']) Pencarian: "{{ $filters['search'] }}" @endif
    @if($filters['status']) &nbsp;| Status: {{ ucfirst($filters['status']) }} @endif
    @if($filters['supplier_name']) &nbsp;| Supplier: {{ $filters['supplier_name'] }} @endif
    @if($filters['start_date'] && $filters['end_date'])
        &nbsp;| Tanggal: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }}
        — {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}
    @endif
</div>
@endif

{{-- ── DATA TABLE ── --}}
<table class="data-table">
    <thead>
        <tr>
            <th class="center" style="width:24px;">No</th>
            <th style="width:100px;">Kode Restock</th>
            <th class="center" style="width:62px;">Tanggal</th>
            <th style="width:100px;">Supplier</th>
            <th class="right" style="width:95px;">Total Biaya</th>
            <th class="center" style="width:60px;">Status</th>
            <th style="width:85px;">Dibuat Oleh</th>
            <th>Keterangan &amp; Detail Produk</th>
        </tr>
    </thead>
    <tbody>
        @forelse($restocks as $index => $item)
        <tr class="{{ $index % 2 === 0 ? 'odd' : 'even' }}">
            {{-- No --}}
            <td class="center middle">{{ $index + 1 }}</td>

            {{-- Kode --}}
            <td class="middle"><strong>{{ $item->kode_restock }}</strong></td>

            {{-- Tanggal --}}
            <td class="center middle">{{ $item->tanggal_restock->format('d/m/Y') }}</td>

            {{-- Supplier --}}
            <td class="middle">
                @if($item->supplier)
                    <span class="badge badge-info">{{ $item->supplier->nama }}</span>
                @else
                    <span style="color:#aaa;">Tanpa Supplier</span>
                @endif
            </td>

            {{-- Total Biaya --}}
            <td class="right middle"><strong>Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</strong></td>

            {{-- Status --}}
            <td class="center middle">
                @if($item->status === 'selesai')
                    <span class="badge badge-success">Selesai</span>
                @elseif($item->status === 'draft')
                    <span class="badge badge-warning">Draft</span>
                @else
                    <span class="badge badge-danger">Dibatalkan</span>
                @endif
            </td>

            {{-- Dibuat Oleh --}}
            <td class="middle">{{ $item->user->name ?? '-' }}</td>

            {{-- Keterangan + Detail Produk --}}
            <td>
                @if($item->keterangan)
                    <div style="margin-bottom:6px; font-style:italic; color:#555; font-size:9px;">
                        {{ $item->keterangan }}
                    </div>
                @endif

                @if($item->details && $item->details->count() > 0)
                <div class="detail-wrapper">
                    <div class="detail-label">&#9656; Detail Produk ({{ $item->details->count() }} item)</div>
                    <table class="detail-table">
                        <thead>
                            <tr>
                                <th class="center" style="width:18px;">#</th>
                                <th style="width:80px;">Kode Produk</th>
                                <th>Nama Produk</th>
                                <th class="center" style="width:36px;">Jml</th>
                                <th class="center" style="width:28px;">Sat</th>
                                <th class="right" style="width:72px;">Harga Beli</th>
                                <th class="right" style="width:72px;">Subtotal</th>
                                <th style="width:70px;">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($item->details as $di => $detail)
                            <tr>
                                <td class="center">{{ $di + 1 }}</td>
                                <td>
                                    @if($detail->produk)
                                        <span style="font-size:8px; color:#666;">{{ $detail->produk->kode_produk }}</span>
                                    @else
                                        <span style="color:#aaa;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($detail->produk)
                                        {{ $detail->produk->nama }}
                                        @if($detail->produk->kategori)
                                            <br><span style="font-size:8px; color:#999;">{{ $detail->produk->kategori->nama }}</span>
                                        @endif
                                    @else
                                        <span style="color:#aaa;">Produk dihapus</span>
                                    @endif
                                </td>
                                <td class="center"><strong>{{ number_format($detail->jumlah, 0, ',', '.') }}</strong></td>
                                <td class="center" style="font-size:8px; color:#666;">
                                    {{ $detail->produk->satuan ?? '-' }}
                                </td>
                                <td class="right">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                <td class="right"><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                                <td style="font-size:8px; color:#666;">{{ $detail->catatan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" style="text-align:right;">Subtotal Restock:</td>
                                <td class="right">
                                    Rp {{ number_format($item->details->sum('subtotal'), 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                    <span style="color:#aaa; font-size:9px; font-style:italic;">Tidak ada detail produk</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="center" style="padding:20px; color:#aaa;">
                Tidak ada data restock
            </td>
        </tr>
        @endforelse
    </tbody>
    @if($restocks->count() > 0)
    <tfoot>
        <tr>
            <td colspan="4" style="text-align:right;">TOTAL KESELURUHAN</td>
            <td style="text-align:right;">Rp {{ number_format($restocks->sum('total_biaya'), 0, ',', '.') }}</td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>