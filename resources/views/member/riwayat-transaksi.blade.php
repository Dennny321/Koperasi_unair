<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi — Koperasi Pegawai UNAIR</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:        #2f3291;
            --primary-dark:   #1e2061;
            --primary-light:  rgba(47, 50, 145, 0.08);
            --accent:         #ffca0a;
            --accent-dark:    #e6b709;
            --white:          #ffffff;
            --bg-body:        #f4f7fe;
            --text-main:      #2d3748;
            --text-secondary: #718096;
            --border-color:   #e2e8f0;
            --shadow-soft:    0 4px 20px rgba(112, 144, 176, 0.08);
            --shadow-card:    0 2px 10px rgba(112, 144, 176, 0.06);
            --success:        #10b981;
            --danger:         #ef4444;
            --warning:        #f59e0b;
            --info:           #3b82f6;
            --transition:     all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
        }

        .page-wrapper { display: flex; flex-direction: column; min-height: 100vh; }

        /* ===== TOPBAR ===== */
        .topbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 0 32px; height: 68px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 16px rgba(47, 50, 145, 0.25);
        }

        .topbar-left { display: flex; align-items: center; gap: 14px; }

        .topbar-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }

        .topbar-logo-box {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center; padding: 5px;
        }

        .topbar-logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .topbar-brand { font-weight: 800; font-size: 15px; color: var(--white); line-height: 1.2; }
        .topbar-brand span { color: var(--accent); }
        .topbar-divider { width: 1px; height: 28px; background: rgba(255,255,255,0.2); margin: 0 4px; }

        .member-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255, 202, 10, 0.15);
            border: 1px solid rgba(255, 202, 10, 0.3);
            border-radius: 100px; padding: 4px 12px;
        }

        .member-chip i { font-size: 11px; color: var(--accent); }
        .member-chip span { font-size: 12px; font-weight: 700; color: var(--accent); letter-spacing: 0.5px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .user-dropdown {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px; padding: 6px 14px 6px 8px;
            cursor: pointer; transition: var(--transition); position: relative;
        }

        .user-dropdown:hover { background: rgba(255,255,255,0.16); }

        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 13px; color: var(--primary-dark); flex-shrink: 0;
        }

        .user-info-top span { display: block; font-size: 13px; font-weight: 700; color: var(--white); line-height: 1.2; }
        .user-info-top small { font-size: 11px; color: rgba(255,255,255,0.6); }

        .dropdown-menu-custom {
            display: none;
            position: absolute; top: calc(100% + 4px); right: 0;
            background: var(--white); border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            border: 1px solid var(--border-color);
            min-width: 200px; overflow: hidden; z-index: 200;
            animation: fadeInDown 0.2s ease;
        }

        .user-dropdown::after { content: ''; position: absolute; bottom: -8px; left: 0; right: 0; height: 8px; background: transparent; }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-dropdown:hover .dropdown-menu-custom, .dropdown-menu-custom:hover { display: block; }

        .dropdown-item-custom {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; font-size: 13.5px; color: var(--text-main);
            text-decoration: none; transition: background 0.15s;
        }

        .dropdown-item-custom i { width: 16px; color: var(--text-secondary); font-size: 13px; }
        .dropdown-item-custom:hover { background: var(--bg-body); }
        .dropdown-item-custom.danger { color: var(--danger); }
        .dropdown-item-custom.danger i { color: var(--danger); }
        .dropdown-divider { height: 1px; background: var(--border-color); margin: 4px 0; }

        /* ===== CONTENT ===== */
        .content {
            flex: 1; padding: 32px;
            max-width: 1100px; width: 100%; margin: 0 auto;
        }

        /* ===== PAGE HEADER ===== */
        .page-header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }

        .back-btn {
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--white); border: 1.5px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary); text-decoration: none;
            font-size: 14px; transition: var(--transition); flex-shrink: 0;
        }

        .back-btn:hover { background: var(--primary-light); border-color: var(--primary); color: var(--primary); }

        .page-title-block { flex: 1; }
        .page-title { font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 2px; }
        .page-subtitle { font-size: 13px; color: var(--text-secondary); }

        /* ===== SUMMARY CARDS ===== */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }

        .summary-card {
            background: var(--white); border-radius: 14px;
            padding: 18px 20px; box-shadow: var(--shadow-card);
            display: flex; align-items: center; gap: 14px;
        }

        .summary-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }

        .summary-icon.primary { background: var(--primary-light); color: var(--primary); }
        .summary-icon.success { background: rgba(16,185,129,0.1); color: var(--success); }
        .summary-icon.warning { background: rgba(245,158,11,0.1); color: var(--warning); }

        .summary-label { font-size: 11px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
        .summary-value { font-size: 18px; font-weight: 800; color: var(--text-main); }
        .summary-value.lg { font-size: 22px; }

        /* ===== FILTER BAR ===== */
        .filter-bar {
            background: var(--white); border-radius: 14px;
            padding: 16px 20px; box-shadow: var(--shadow-card);
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        }

        .filter-label { font-size: 13px; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }
        .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }

        .filter-btn {
            padding: 6px 16px; border-radius: 100px;
            font-size: 12.5px; font-weight: 600;
            border: 1.5px solid var(--border-color);
            background: transparent; color: var(--text-secondary);
            cursor: pointer; transition: var(--transition); text-decoration: none;
        }

        .filter-btn:hover, .filter-btn.active { background: var(--primary); border-color: var(--primary); color: var(--white); }

        .filter-btn.success-btn.active { background: var(--success); border-color: var(--success); }
        .filter-btn.danger-btn.active { background: var(--danger); border-color: var(--danger); }

        .filter-spacer { flex: 1; }

        .search-wrapper { position: relative; }
        .search-wrapper i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 13px; }

        .search-input {
            padding: 7px 14px 7px 36px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px; font-size: 13px;
            font-family: inherit; outline: none;
            transition: border-color 0.2s;
            background: var(--bg-body); min-width: 200px;
        }

        .search-input:focus { border-color: var(--primary); }

        /* ===== MAIN PANEL ===== */
        .main-panel {
            background: var(--white); border-radius: 16px;
            box-shadow: var(--shadow-card); overflow: hidden;
        }

        .panel-header {
            padding: 18px 24px; border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
        }

        .panel-title {
            font-size: 15px; font-weight: 700; color: var(--text-main);
            display: flex; align-items: center; gap: 8px;
        }

        .panel-title i {
            width: 30px; height: 30px; background: var(--primary-light);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: var(--primary);
        }

        .count-badge { background: var(--primary-light); color: var(--primary); font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 100px; }

        /* ===== TRANSAKSI TABLE ===== */
        .trx-table { width: 100%; border-collapse: collapse; }

        .trx-table th {
            padding: 12px 20px;
            font-size: 11px; font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase; letter-spacing: 0.5px;
            background: var(--bg-body);
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .trx-table td {
            padding: 14px 20px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            vertical-align: middle;
        }

        .trx-table tr:last-child td { border-bottom: none; }

        .trx-table tbody tr:hover td { background: var(--bg-body); }

        .trx-no {
            font-weight: 700; color: var(--primary);
            font-family: monospace; font-size: 13px;
            letter-spacing: 0.3px;
        }

        .trx-tanggal { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

        .trx-total { font-weight: 700; font-size: 14px; }

        .trx-metode {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 100px;
            font-size: 11px; font-weight: 700;
            background: var(--primary-light); color: var(--primary);
        }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 100px;
            font-size: 11px; font-weight: 700;
        }

        .badge-success { background: rgba(16,185,129,0.1); color: var(--success); }
        .badge-danger  { background: rgba(239,68,68,0.1);  color: var(--danger); }
        .badge-warning { background: rgba(245,158,11,0.1); color: var(--warning); }

        /* ===== EMPTY STATE ===== */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-secondary); }

        .empty-state .empty-icon {
            width: 72px; height: 72px; background: var(--bg-body);
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: var(--border-color); margin: 0 auto 16px;
        }

        .empty-state h3 { font-size: 15px; font-weight: 700; margin-bottom: 6px; color: var(--text-main); }
        .empty-state p { font-size: 13px; }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            padding: 16px 24px; border-top: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
        }

        .pagination-info { font-size: 13px; color: var(--text-secondary); }
        .pagination-links { display: flex; gap: 6px; }

        .page-link {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; text-decoration: none;
            border: 1.5px solid var(--border-color); color: var(--text-secondary);
            transition: var(--transition);
        }

        .page-link:hover, .page-link.active { background: var(--primary); border-color: var(--primary); color: var(--white); }
        .page-link.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center; padding: 20px 32px; font-size: 12.5px;
            color: var(--text-secondary); border-top: 1px solid var(--border-color);
            background: var(--white);
        }

        .page-footer span { color: var(--primary); font-weight: 700; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .topbar-brand, .topbar-divider, .member-chip { display: none; }
            .summary-grid { grid-template-columns: 1fr 1fr; }
            .trx-table th:nth-child(3), .trx-table td:nth-child(3),
            .trx-table th:nth-child(4), .trx-table td:nth-child(4) { display: none; }
        }

        @media (max-width: 480px) {
            .summary-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="page-wrapper">

    {{-- ===== TOPBAR ===== --}}
    <header class="topbar">
        <div class="topbar-left">
            <a href="{{ route('member.dashboard') }}" class="topbar-logo">
                <div class="topbar-logo-box">
                    <img src="{{ asset('images/unair-logo.png') }}" alt="UNAIR">
                </div>
                <div class="topbar-brand">KOPERASI<span><br>UNAIR</span></div>
            </a>
            <div class="topbar-divider"></div>
            <div class="member-chip">
                <i class="fas fa-id-card"></i>
                <span>MEMBER AREA</span>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-dropdown">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name ?? $user->no_telepon, 0, 2)) }}
                </div>
                <div class="user-info-top">
                    <span>{{ $user->name ?? 'Member' }}</span>
                    <small>{{ $user->no_telepon }}</small>
                </div>
                <i class="fas fa-chevron-down" style="font-size:10px;color:rgba(255,255,255,0.5);margin-left:4px;"></i>

                <div class="dropdown-menu-custom">
                    <a href="{{ route('member.profil') }}" class="dropdown-item-custom">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                    <a href="{{ route('member.riwayat-transaksi') }}" class="dropdown-item-custom" style="font-weight:700;color:var(--primary);">
                        <i class="fas fa-history" style="color:var(--primary)"></i> Riwayat Transaksi
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('member.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item-custom danger" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <a href="{{ route('member.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="page-title-block">
                <h1 class="page-title">Riwayat Transaksi</h1>
                <p class="page-subtitle">Semua transaksi belanja kamu</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <div class="summary-label">Total Transaksi</div>
                    <div class="summary-value lg">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="summary-label">Total Belanja</div>
                    <div class="summary-value" style="font-size:15px;">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon warning">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <div class="summary-label">Poin Terkumpul</div>
                    <div class="summary-value lg">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <span class="filter-label">Status:</span>
            <div class="filter-group">
                <a href="{{ route('member.riwayat-transaksi') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('member.riwayat-transaksi', ['status' => 'selesai']) }}" class="filter-btn success-btn {{ request('status') === 'selesai' ? 'active' : '' }}">
                    <i class="fas fa-check" style="font-size:10px;margin-right:4px;"></i> Selesai
                </a>
                <a href="{{ route('member.riwayat-transaksi', ['status' => 'proses']) }}" class="filter-btn {{ request('status') === 'proses' ? 'active' : '' }}">
                    <i class="fas fa-clock" style="font-size:10px;margin-right:4px;"></i> Proses
                </a>
                <a href="{{ route('member.riwayat-transaksi', ['status' => 'batal']) }}" class="filter-btn danger-btn {{ request('status') === 'batal' ? 'active' : '' }}">
                    <i class="fas fa-times" style="font-size:10px;margin-right:4px;"></i> Batal
                </a>
            </div>
            <div class="filter-spacer"></div>
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    class="search-input"
                    placeholder="Cari no. transaksi..."
                    id="searchInput"
                    onkeyup="filterTrx(this.value)"
                >
            </div>
        </div>

        {{-- Main Panel --}}
        <div class="main-panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-receipt"></i>
                    Semua Transaksi
                </div>
                <span class="count-badge">{{ $transaksi->total() }} transaksi</span>
            </div>

            @if($transaksi->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3>Belum ada transaksi</h3>
                    <p>Kamu belum melakukan transaksi apapun.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="trx-table" id="trxTable">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Tanggal</th>
                                <th>Metode Bayar</th>
                                <th>Poin Diperoleh</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $trx)
                            <tr data-no="{{ strtolower($trx->no_transaksi) }}">
                                <td>
                                    <div class="trx-no">{{ $trx->no_transaksi }}</div>
                                    @if($trx->no_nota)
                                        <div style="font-size:11px;color:var(--text-secondary);margin-top:2px;">
                                            Nota: {{ $trx->no_nota }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $trx->dibuat_pada?->format('d M Y') }}</div>
                                    <div class="trx-tanggal">{{ $trx->dibuat_pada?->format('H:i') }}</div>
                                </td>
                                <td>
                                    <span class="trx-metode">
                                        <i class="fas fa-{{ $trx->metode_bayar === 'tunai' ? 'money-bill' : 'credit-card' }}"></i>
                                        {{ ucfirst($trx->metode_bayar) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $poin = $trx->riwayatPoin?->poin ?? 0;
                                    @endphp
                                    @if($poin > 0)
                                        <span style="color:var(--success);font-weight:700;">
                                            +{{ number_format($poin, 0, ',', '.') }} poin
                                        </span>
                                    @else
                                        <span style="color:var(--text-secondary);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="trx-total">{{ $trx->total_harga_formatted }}</div>
                                    @if($trx->kembalian > 0)
                                        <div style="font-size:11px;color:var(--text-secondary);">Kembalian: {{ $trx->kembalian_formatted }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $trx->status === 'selesai' ? 'success' : ($trx->status === 'batal' ? 'danger' : 'warning') }}">
                                        <i class="fas fa-{{ $trx->status === 'selesai' ? 'check' : ($trx->status === 'batal' ? 'times' : 'clock') }}"></i>
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($transaksi->hasPages())
                <div class="pagination-wrapper">
                    <span class="pagination-info">
                        Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi
                    </span>
                    <div class="pagination-links">
                        @if($transaksi->onFirstPage())
                            <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $transaksi->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach($transaksi->getUrlRange(1, $transaksi->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page === $transaksi->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if($transaksi->hasMorePages())
                            <a href="{{ $transaksi->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>

    </main>

    <footer class="page-footer">
        © {{ date('Y') }} <span>Koperasi Pegawai UNAIR</span> · Semua hak dilindungi
    </footer>

</div>

<script>
function filterTrx(query) {
    const rows = document.querySelectorAll('#trxTable tbody tr');
    query = query.toLowerCase();
    rows.forEach(row => {
        const no = row.getAttribute('data-no') || '';
        row.style.display = no.includes(query) ? '' : 'none';
    });
}
</script>
</body>
</html>