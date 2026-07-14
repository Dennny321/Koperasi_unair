<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member — Koperasi Pegawai UNAIR</title>
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

        /* ===================== LAYOUT ===================== */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===================== TOPBAR ===================== */
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

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
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

        .topbar-logo-box img {
            width: 100%; height: 100%;
            object-fit: contain;
        }

        .topbar-brand {
            font-weight: 800;
            font-size: 15px;
            color: var(--white);
            line-height: 1.2;
        }

        .topbar-brand span { color: var(--accent); }

        .topbar-divider {
            width: 1px; height: 28px;
            background: rgba(255,255,255,0.2);
            margin: 0 4px;
        }

        .member-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 202, 10, 0.15);
            border: 1px solid rgba(255, 202, 10, 0.3);
            border-radius: 100px;
            padding: 4px 12px;
        }

        .member-chip i { font-size: 11px; color: var(--accent); }
        .member-chip span { font-size: 12px; font-weight: 700; color: var(--accent); letter-spacing: 0.5px; }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* FIX: User Dropdown with proper hover */
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .user-dropdown:hover { 
            background: rgba(255,255,255,0.16); 
        }

        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 13px;
            color: var(--primary-dark);
            flex-shrink: 0;
        }

        .user-info-top span {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
        }

        .user-info-top small {
            font-size: 11px;
            color: rgba(255,255,255,0.6);
        }

        /* FIX: Dropdown menu dengan gap yang tepat */
        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: calc(100% + 4px); /* Kurangi gap dari 10px ke 4px */
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

        /* FIX: Tambahkan pseudo-element untuk menjembatani gap */
        .user-dropdown::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 8px;
            background: transparent;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* FIX: Gunakan kombinasi hover yang lebih reliable */
        .user-dropdown:hover .dropdown-menu-custom,
        .dropdown-menu-custom:hover {
            display: block;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            font-size: 13.5px;
            color: var(--text-main);
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-item-custom i { 
            width: 16px; 
            color: var(--text-secondary); 
            font-size: 13px; 
        }
        
        .dropdown-item-custom:hover { 
            background: var(--bg-body); 
        }

        .dropdown-item-custom.danger { 
            color: var(--danger); 
        }
        
        .dropdown-item-custom.danger i { 
            color: var(--danger); 
        }

        .dropdown-divider { 
            height: 1px; 
            background: var(--border-color); 
            margin: 4px 0; 
        }

        /* ===================== CONTENT ===================== */
        .content {
            flex: 1;
            padding: 32px;
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }

        /* ===================== HERO BANNER ===================== */
        .hero-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 20px;
            padding: 32px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -120px; right: -80px;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255, 202, 10, 0.07);
            bottom: -60px; left: 200px;
        }

        .hero-text { z-index: 1; }

        .hero-greeting {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .hero-name {
            font-size: 26px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 8px;
        }

        .hero-name span { color: var(--accent); }

        .hero-sub {
            font-size: 13.5px;
            color: rgba(255,255,255,0.65);
        }

        .hero-poin {
            z-index: 1;
            text-align: right;
        }

        .poin-label {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 4px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .poin-value {
            font-size: 44px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 4px;
        }

        .poin-unit {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }

        /* ===================== STAT CARDS ===================== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .stat-icon.primary  { background: var(--primary-light); color: var(--primary); }
        .stat-icon.success  { background: rgba(16,185,129,0.1);  color: var(--success); }
        .stat-icon.warning  { background: rgba(245,158,11,0.1);  color: var(--warning); }
        .stat-icon.accent   { background: rgba(255,202,10,0.12); color: #a07800; }

        .stat-info { flex: 1; min-width: 0; }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            margin-bottom: 2px;
        }

        .stat-desc {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* ===================== GRID PANELS ===================== */
        .panels-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        .panel {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        .panel-title i {
            width: 32px; height: 32px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            color: var(--primary);
        }

        .panel-link {
            font-size: 12.5px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .panel-link:hover { color: var(--primary-dark); text-decoration: underline; }

        .panel-body { padding: 0; }

        /* ===================== RIWAYAT POIN ===================== */
        .poin-list { list-style: none; }

        .poin-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.15s;
        }

        .poin-item:last-child { border-bottom: none; }
        .poin-item:hover { background: var(--bg-body); }

        .poin-dot {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .poin-dot.masuk  { background: rgba(16,185,129,0.1);  color: var(--success); }
        .poin-dot.keluar { background: rgba(239,68,68,0.1);   color: var(--danger); }

        .poin-detail { flex: 1; min-width: 0; }

        .poin-keterangan {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .poin-tanggal {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .poin-amount {
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .poin-amount.masuk  { color: var(--success); }
        .poin-amount.keluar { color: var(--danger); }

        /* ===================== TRANSAKSI ===================== */
        .transaksi-list { list-style: none; }

        .transaksi-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.15s;
        }

        .transaksi-item:last-child { border-bottom: none; }
        .transaksi-item:hover { background: var(--bg-body); }

        .transaksi-icon {
            width: 36px; height: 36px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .transaksi-detail { flex: 1; min-width: 0; }

        .transaksi-no {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
            font-family: monospace;
            letter-spacing: 0.3px;
        }

        .transaksi-tanggal {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .transaksi-total {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            flex-shrink: 0;
            text-align: right;
        }

        .transaksi-metode {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ===================== BADGE STATUS ===================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-success { background: rgba(16,185,129,0.1);  color: var(--success); }
        .badge-danger  { background: rgba(239,68,68,0.1);   color: var(--danger);  }
        .badge-warning { background: rgba(245,158,11,0.1);  color: var(--warning); }
        .badge-primary { background: var(--primary-light);  color: var(--primary); }

        /* ===================== HADIAH SECTION ===================== */
        .hadiah-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 20px 24px;
        }

        .hadiah-card {
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 18px 16px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .hadiah-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 16px rgba(47,50,145,0.1);
            transform: translateY(-2px);
        }

        .hadiah-card.bisa-tukar { border-color: var(--accent); }
        .hadiah-card.bisa-tukar::before {
            content: '✓ Bisa Tukar';
            position: absolute;
            top: 10px; right: -22px;
            background: var(--accent);
            color: var(--primary-dark);
            font-size: 9px;
            font-weight: 800;
            padding: 3px 28px;
            transform: rotate(35deg);
            letter-spacing: 0.3px;
        }

        .hadiah-icon {
            width: 48px; height: 48px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            color: var(--primary);
            margin: 0 auto 12px;
        }

        .hadiah-nama {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .hadiah-poin {
            font-size: 15px;
            font-weight: 800;
            color: var(--primary);
        }

        .hadiah-poin span { font-size: 11px; font-weight: 500; color: var(--text-secondary); }

        .hadiah-stok {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ===================== PENUKARAN SECTION ===================== */
        .penukaran-list { list-style: none; }

        .penukaran-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .penukaran-item:last-child { border-bottom: none; }

        .penukaran-icon {
            width: 36px; height: 36px;
            background: rgba(255,202,10,0.12);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; color: #a07800;
            flex-shrink: 0;
        }

        .penukaran-detail { flex: 1; min-width: 0; }

        .penukaran-nama {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .penukaran-kode {
            font-size: 11.5px;
            color: var(--text-secondary);
            font-family: monospace;
        }

        /* ===================== EMPTY STATE ===================== */
        .empty-state {
            text-align: center;
            padding: 32px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 32px;
            opacity: 0.25;
            display: block;
            margin-bottom: 10px;
        }

        .empty-state p { font-size: 13.5px; }

        /* ===================== ALERT ===================== */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert i { font-size: 16px; }
        .alert-success { background: rgba(16,185,129,0.1); color: var(--success); border-left: 4px solid var(--success); }
        .alert-danger  { background: rgba(239,68,68,0.1);  color: var(--danger);  border-left: 4px solid var(--danger);  }

        /* ===================== FOOTER ===================== */
        .page-footer {
            text-align: center;
            padding: 20px 32px;
            font-size: 12.5px;
            color: var(--text-secondary);
            border-top: 1px solid var(--border-color);
            background: var(--white);
        }

        .page-footer span { color: var(--primary); font-weight: 700; }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(3, 1fr); }
            .hadiah-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .content { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .topbar-brand, .topbar-divider, .member-chip { display: none; }
            .hero-banner { flex-direction: column; gap: 20px; text-align: center; }
            .hero-poin { text-align: center; }
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .panels-grid { grid-template-columns: 1fr; }
            .hadiah-grid { grid-template-columns: repeat(2, 1fr); }
            .poin-value { font-size: 36px; }
        }

        @media (max-width: 480px) {
            .stat-grid { grid-template-columns: 1fr; }
            .hadiah-grid { grid-template-columns: 1fr 1fr; }
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

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ===== HERO BANNER ===== --}}
        <div class="hero-banner">
            <div class="hero-text">
                <p class="hero-greeting">
                    <i class="fas fa-sun" style="color:var(--accent);margin-right:6px;"></i>
                    Selamat datang kembali,
                </p>
                <h1 class="hero-name">
                    {{ $user->name ?? 'Member' }} <span>👋</span>
                </h1>
                <p class="hero-sub">
                    <i class="fas fa-phone" style="margin-right:5px;opacity:0.6;"></i>
                    {{ $user->no_telepon }} &nbsp;·&nbsp;
                    <i class="fas fa-calendar-alt" style="margin-right:5px;opacity:0.6;"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="hero-poin">
                <p class="poin-label">Saldo Poin</p>
                <div class="poin-value">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                <p class="poin-unit">poin tersisa</p>
            </div>
        </div>

        {{-- ===== STAT CARDS ===== --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-coins"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Saldo Poin</div>
                    <div class="stat-value">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                    <div class="stat-desc">poin aktif</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-arrow-down"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Poin Masuk</div>
                    <div class="stat-value">{{ number_format($totalPoinMasuk, 0, ',', '.') }}</div>
                    <div class="stat-desc">total diperoleh</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-info">
                    <div class="stat-label">Transaksi</div>
                    <div class="stat-value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                    <div class="stat-desc">total transaksi</div>
                </div>
            </div>
        </div>

        {{-- ===== RIWAYAT POIN + TRANSAKSI ===== --}}
        <div class="panels-grid">

            {{-- Riwayat Poin --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="fas fa-history"></i>
                        Riwayat Poin
                    </div>
                    <a href="{{ route('member.riwayat-poin') }}" class="panel-link">Lihat Semua →</a>
                </div>
                <div class="panel-body">
                    @if($riwayatPoin->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada riwayat poin</p>
                        </div>
                    @else
                        <ul class="poin-list">
                            @foreach($riwayatPoin as $riwayat)
                                <li class="poin-item">
                                    <div class="poin-dot {{ $riwayat->jenis }}">
                                        <i class="fas fa-{{ $riwayat->isMasuk() ? 'plus' : 'minus' }}"></i>
                                    </div>
                                    <div class="poin-detail">
                                        <div class="poin-keterangan">{{ $riwayat->keterangan ?? '-' }}</div>
                                        <div class="poin-tanggal">{{ $riwayat->dibuat_pada?->format('d M Y, H:i') ?? '-' }}</div>
                                    </div>
                                    <div class="poin-amount {{ $riwayat->jenis }}">
                                        {{ $riwayat->poin_formatted }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Transaksi Terbaru --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class="fas fa-receipt"></i>
                        Transaksi Terbaru
                    </div>
                    <a href="{{ route('member.riwayat-transaksi') }}" class="panel-link">Lihat Semua →</a>
                </div>
                <div class="panel-body">
                    @if($transaksiTerbaru->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    @else
                        <ul class="transaksi-list">
                            @foreach($transaksiTerbaru as $trx)
                                <li class="transaksi-item">
                                    <div class="transaksi-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="transaksi-detail">
                                        <div class="transaksi-no">{{ $trx->no_transaksi }}</div>
                                        <div class="transaksi-tanggal">{{ $trx->dibuat_pada?->format('d M Y, H:i') ?? '-' }}</div>
                                    </div>
                                    <div style="text-align:right;flex-shrink:0;">
                                        <div class="transaksi-total">{{ $trx->total_harga_formatted }}</div>
                                        <div class="transaksi-metode">{{ ucfirst($trx->metode_bayar) }}</div>
                                        <span class="badge badge-{{ $trx->status === 'selesai' ? 'success' : ($trx->status === 'batal' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($trx->status) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== HADIAH TERSEDIA ===== --}}
        <div class="panel" style="margin-bottom:28px;">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-gift"></i>
                    Hadiah Tersedia
                </div>
                <a href="{{ route('member.penukaran.index') }}" class="panel-link">Semua Hadiah →</a>
            </div>
            <div class="panel-body">
                @if($hadiahTersedia->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-gift"></i>
                        <p>Belum ada hadiah tersedia saat ini</p>
                    </div>
                @else
                    <div class="hadiah-grid">
                        @foreach($hadiahTersedia as $hadiah)
                        @php $bisa = $user->saldo_poin >= $hadiah->biaya_poin; @endphp
                            <a href="{{ route('member.penukaran.index') }}" style="text-decoration:none;">
                            <div class="hadiah-card {{ $bisa ? 'bisa-tukar' : '' }}" style="cursor:pointer;">
                                <div class="hadiah-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="hadiah-nama">{{ $hadiah->nama }}</div>
                                <div class="hadiah-poin">
                                    {{ number_format($hadiah->biaya_poin, 0, ',', '.') }}
                                    <span>poin</span>
                                </div>
                                <div class="hadiah-stok">Stok: {{ $hadiah->stok }}</div>
                                @if($bisa)
                                <div style="margin-top:10px;">
                                    <span style="display:block; width:100%; padding:8px; background:var(--primary, #2f3291); color:white; border-radius:8px; font-size:12px; font-weight:700; text-align:center;">
                                        <i class="fas fa-exchange-alt"></i> Tukar Sekarang
                                    </span>
                                </div>
                                @else
                                <div style="margin-top:10px;">
                                    <span style="display:block; width:100%; padding:8px; background:#e2e8f0; color:#718096; border-radius:8px; font-size:12px; font-weight:700; text-align:center;">
                                        <i class="fas fa-lock"></i> Poin Kurang
                                    </span>
                                </div>
                                @endif
                            </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== PENUKARAN MENUNGGU ===== --}}
        @if($penukaranMenunggu->isNotEmpty())
        <div class="panel" style="margin-bottom:28px;">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-clock"></i>
                    Penukaran Menunggu Konfirmasi
                </div>
            </div>
            <div class="panel-body">
                <ul class="penukaran-list">
                    @foreach($penukaranMenunggu as $tukar)
                        <li class="penukaran-item">
                            <div class="penukaran-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="penukaran-detail">
                                <div class="penukaran-nama">{{ $tukar->hadiah->nama ?? '-' }}</div>
                                <div class="penukaran-kode">{{ $tukar->kode_unik }}</div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <div style="font-size:14px;font-weight:700;color:#a07800;">
                                    {{ number_format($tukar->poin_digunakan, 0, ',', '.') }} poin
                                </div>
                                <span class="badge badge-warning">Menunggu</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="page-footer">
        © {{ date('Y') }} <span>Koperasi Pegawai UNAIR</span> · Semua hak dilindungi
    </footer>

</div>
</body>
</html>