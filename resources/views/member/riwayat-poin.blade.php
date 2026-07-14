<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Poin — Koperasi Pegawai UNAIR</title>
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
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 16px rgba(47, 50, 145, 0.25);
        }

        .topbar-left { display: flex; align-items: center; gap: 14px; }

        .topbar-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }

        .topbar-logo-box {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            padding: 5px;
        }

        .topbar-logo-box img { width: 100%; height: 100%; object-fit: contain; }

        .topbar-brand { font-weight: 800; font-size: 15px; color: var(--white); line-height: 1.2; }
        .topbar-brand span { color: var(--accent); }

        .topbar-divider { width: 1px; height: 28px; background: rgba(255,255,255,0.2); margin: 0 4px; }

        .member-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255, 202, 10, 0.15);
            border: 1px solid rgba(255, 202, 10, 0.3);
            border-radius: 100px;
            padding: 4px 12px;
        }

        .member-chip i { font-size: 11px; color: var(--accent); }
        .member-chip span { font-size: 12px; font-weight: 700; color: var(--accent); letter-spacing: 0.5px; }

        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .user-dropdown {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .user-dropdown:hover { background: rgba(255,255,255,0.16); }

        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 13px;
            color: var(--primary-dark);
            flex-shrink: 0;
        }

        .user-info-top span { display: block; font-size: 13px; font-weight: 700; color: var(--white); line-height: 1.2; }
        .user-info-top small { font-size: 11px; color: rgba(255,255,255,0.6); }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            right: 0;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            border: 1px solid var(--border-color);
            min-width: 200px;
            overflow: hidden;
            z-index: 200;
            animation: fadeInDown 0.2s ease;
        }

        .user-dropdown::after {
            content: '';
            position: absolute;
            bottom: -8px; left: 0; right: 0;
            height: 8px; background: transparent;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-dropdown:hover .dropdown-menu-custom,
        .dropdown-menu-custom:hover { display: block; }

        .dropdown-item-custom {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            color: var(--text-main);
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-item-custom i { width: 16px; color: var(--text-secondary); font-size: 13px; }
        .dropdown-item-custom:hover { background: var(--bg-body); }
        .dropdown-item-custom.danger { color: var(--danger); }
        .dropdown-item-custom.danger i { color: var(--danger); }
        .dropdown-divider { height: 1px; background: var(--border-color); margin: 4px 0; }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 32px;
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .back-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--white);
            border: 1.5px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .back-btn:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }

        .page-title-block { flex: 1; }

        .page-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .page-subtitle { font-size: 13px; color: var(--text-secondary); }

        /* ===== SUMMARY CARDS ===== */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--white);
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .summary-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .summary-icon.primary { background: var(--primary-light); color: var(--primary); }
        .summary-icon.success { background: rgba(16,185,129,0.1); color: var(--success); }
        .summary-icon.danger  { background: rgba(239,68,68,0.1); color: var(--danger); }

        .summary-label { font-size: 11px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
        .summary-value { font-size: 22px; font-weight: 800; color: var(--text-main); }

        /* ===== FILTER BAR ===== */
        .filter-bar {
            background: var(--white);
            border-radius: 14px;
            padding: 16px 20px;
            box-shadow: var(--shadow-card);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-label { font-size: 13px; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }

        .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }

        .filter-btn {
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12.5px;
            font-weight: 600;
            border: 1.5px solid var(--border-color);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .filter-btn.success-filter.active {
            background: var(--success);
            border-color: var(--success);
        }

        .filter-btn.danger-filter.active {
            background: var(--danger);
            border-color: var(--danger);
        }

        .filter-spacer { flex: 1; }

        .search-input {
            padding: 7px 14px 7px 36px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
            background: var(--bg-body);
            min-width: 200px;
        }

        .search-input:focus { border-color: var(--primary); }
        .search-wrapper { position: relative; }
        .search-wrapper i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 13px; }

        /* ===== MAIN PANEL ===== */
        .main-panel {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .panel-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-size: 15px; font-weight: 700;
            color: var(--text-main);
            display: flex; align-items: center; gap: 8px;
        }

        .panel-title i {
            width: 30px; height: 30px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            color: var(--primary);
        }

        .count-badge {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 100px;
        }

        /* ===== RIWAYAT LIST ===== */
        .riwayat-list { list-style: none; }

        .riwayat-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.15s;
            cursor: default;
        }

        .riwayat-item:last-child { border-bottom: none; }
        .riwayat-item:hover { background: var(--bg-body); }

        .riwayat-dot {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .riwayat-dot.masuk  { background: rgba(16,185,129,0.1); color: var(--success); }
        .riwayat-dot.keluar { background: rgba(239,68,68,0.1);  color: var(--danger); }

        .riwayat-main { flex: 1; min-width: 0; }

        .riwayat-keterangan {
            font-size: 14px; font-weight: 600;
            color: var(--text-main);
            margin-bottom: 3px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .riwayat-meta {
            display: flex; align-items: center; gap: 10px;
        }

        .riwayat-tanggal { font-size: 12px; color: var(--text-secondary); }

        .riwayat-type {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px;
            border-radius: 100px;
            font-size: 10.5px; font-weight: 700;
        }

        .riwayat-type.masuk  { background: rgba(16,185,129,0.1); color: var(--success); }
        .riwayat-type.keluar { background: rgba(239,68,68,0.1);  color: var(--danger); }

        .riwayat-amount {
            font-size: 18px; font-weight: 800;
            flex-shrink: 0;
            text-align: right;
        }

        .riwayat-amount.masuk  { color: var(--success); }
        .riwayat-amount.keluar { color: var(--danger); }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state .empty-icon {
            width: 72px; height: 72px;
            background: var(--bg-body);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            color: var(--border-color);
            margin: 0 auto 16px;
        }

        .empty-state h3 { font-size: 15px; font-weight: 700; margin-bottom: 6px; color: var(--text-main); }
        .empty-state p { font-size: 13px; }

        /* ===== PAGINATION ===== */
        .pagination-wrapper {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pagination-info { font-size: 13px; color: var(--text-secondary); }

        .pagination-links { display: flex; gap: 6px; }

        .page-link {
            width: 34px; height: 34px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--border-color);
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .page-link:hover, .page-link.active {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .page-link.disabled { opacity: 0.4; cursor: not-allowed; pointer-events: none; }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center;
            padding: 20px 32px;
            font-size: 12.5px;
            color: var(--text-secondary);
            border-top: 1px solid var(--border-color);
            background: var(--white);
        }

        .page-footer span { color: var(--primary); font-weight: 700; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .topbar-brand, .topbar-divider, .member-chip { display: none; }
            .summary-grid { grid-template-columns: 1fr 1fr; }
            .filter-bar { gap: 8px; }
            .search-input { min-width: 160px; }
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
                    <a href="{{ route('member.riwayat-transaksi') }}" class="dropdown-item-custom">
                        <i class="fas fa-history"></i> Riwayat Transaksi
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
                <h1 class="page-title">Riwayat Poin</h1>
                <p class="page-subtitle">Semua aktivitas poin kamu</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <div class="summary-label">Saldo Poin</div>
                    <div class="summary-value">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon success">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <div class="summary-label">Total Masuk</div>
                    <div class="summary-value" style="color:var(--success)">+{{ number_format($totalPoinMasuk, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon danger">
                    <i class="fas fa-minus-circle"></i>
                </div>
                <div>
                    <div class="summary-label">Total Keluar</div>
                    <div class="summary-value" style="color:var(--danger)">-{{ number_format($totalPoinKeluar, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <span class="filter-label">Filter:</span>
            <div class="filter-group">
                <a href="{{ route('member.riwayat-poin') }}" class="filter-btn {{ !request('jenis') ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('member.riwayat-poin', ['jenis' => 'masuk']) }}" class="filter-btn success-filter {{ request('jenis') === 'masuk' ? 'active' : '' }}">
                    <i class="fas fa-plus" style="font-size:10px;margin-right:4px;"></i> Masuk
                </a>
                <a href="{{ route('member.riwayat-poin', ['jenis' => 'keluar']) }}" class="filter-btn danger-filter {{ request('jenis') === 'keluar' ? 'active' : '' }}">
                    <i class="fas fa-minus" style="font-size:10px;margin-right:4px;"></i> Keluar
                </a>
            </div>
            <div class="filter-spacer"></div>
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    class="search-input"
                    placeholder="Cari keterangan..."
                    id="searchInput"
                    value="{{ request('q') }}"
                    onkeyup="filterRiwayat(this.value)"
                >
            </div>
        </div>

        {{-- Main Panel --}}
        <div class="main-panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-history"></i>
                    Semua Riwayat Poin
                </div>
                <span class="count-badge">{{ $riwayatPoin->total() }} entri</span>
            </div>

            @if($riwayatPoin->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                    <h3>Belum ada riwayat poin</h3>
                    <p>Lakukan transaksi untuk mendapatkan poin reward.</p>
                </div>
            @else
                <ul class="riwayat-list" id="riwayatList">
                    @foreach($riwayatPoin as $riwayat)
                        <li class="riwayat-item" data-keterangan="{{ strtolower($riwayat->keterangan ?? '') }}">
                            <div class="riwayat-dot {{ $riwayat->jenis }}">
                                <i class="fas fa-{{ $riwayat->isMasuk() ? 'plus' : 'minus' }}"></i>
                            </div>
                            <div class="riwayat-main">
                                <div class="riwayat-keterangan">{{ $riwayat->keterangan ?? '-' }}</div>
                                <div class="riwayat-meta">
                                    <span class="riwayat-tanggal">
                                        <i class="fas fa-clock" style="margin-right:4px;"></i>
                                        {{ $riwayat->dibuat_pada?->format('d M Y, H:i') ?? '-' }}
                                    </span>
                                    <span class="riwayat-type {{ $riwayat->jenis }}">
                                        <i class="fas fa-{{ $riwayat->isMasuk() ? 'arrow-up' : 'arrow-down' }}"></i>
                                        {{ ucfirst($riwayat->jenis) }}
                                    </span>
                                </div>
                            </div>
                            <div class="riwayat-amount {{ $riwayat->jenis }}">
                                {{ $riwayat->poin_formatted }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Pagination --}}
                @if($riwayatPoin->hasPages())
                <div class="pagination-wrapper">
                    <span class="pagination-info">
                        Menampilkan {{ $riwayatPoin->firstItem() }}–{{ $riwayatPoin->lastItem() }} dari {{ $riwayatPoin->total() }} entri
                    </span>
                    <div class="pagination-links">
                        @if($riwayatPoin->onFirstPage())
                            <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $riwayatPoin->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach($riwayatPoin->getUrlRange(1, $riwayatPoin->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-link {{ $page === $riwayatPoin->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        @if($riwayatPoin->hasMorePages())
                            <a href="{{ $riwayatPoin->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a>
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
function filterRiwayat(query) {
    const items = document.querySelectorAll('#riwayatList .riwayat-item');
    query = query.toLowerCase();
    items.forEach(item => {
        const keterangan = item.getAttribute('data-keterangan') || '';
        item.style.display = keterangan.includes(query) ? '' : 'none';
    });
}
</script>
</body>
</html>