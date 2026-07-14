<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — Koperasi Pegawai UNAIR</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #2f3291;
            --primary-dark: #1e2061;
            --primary-light: rgba(47, 50, 145, 0.08);
            --accent: #ffca0a;
            --accent-dark: #e6b709;
            --white: #ffffff;
            --bg-body: #f4f7fe;
            --text-main: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --shadow-soft: 0 4px 20px rgba(112, 144, 176, 0.08);
            --shadow-card: 0 2px 10px rgba(112, 144, 176, 0.06);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

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
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .topbar-brand {
            font-weight: 800;
            font-size: 15px;
            color: var(--white);
            line-height: 1.2;
        }

        .topbar-brand span {
            color: var(--accent);
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
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

        .member-chip i {
            font-size: 11px;
            color: var(--accent);
        }

        .member-chip span {
            font-size: 12px;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.5px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
            color: var(--primary-dark);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
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
            color: rgba(255, 255, 255, 0.6);
        }

        .dropdown-menu-custom {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            right: 0;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--border-color);
            min-width: 200px;
            overflow: hidden;
            z-index: 200;
            animation: fadeInDown 0.2s ease;
        }

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

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 32px;
            max-width: 800px;
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
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--white);
            border: 1.5px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
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

        .page-title-block {
            flex: 1;
        }

        .page-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* ===== PROFILE HERO ===== */
        .profile-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 20px;
            padding: 32px;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            top: -100px;
            right: -60px;
        }

        .profile-avatar-lg {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            z-index: 1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .profile-hero-info {
            flex: 1;
            z-index: 1;
        }

        .profile-hero-name {
            font-size: 22px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 6px;
        }

        .profile-hero-phone {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        .profile-hero-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .hero-badge.member {
            background: rgba(255, 202, 10, 0.15);
            border: 1px solid rgba(255, 202, 10, 0.3);
            color: var(--accent);
        }

        .hero-badge.poin {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        .profile-hero-poin {
            z-index: 1;
            text-align: right;
        }

        .poin-label-sm {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .poin-big {
            font-size: 36px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .poin-unit-sm {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
        }

        /* ===== STATS ROW ===== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-mini {
            background: var(--white);
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: var(--shadow-card);
            text-align: center;
        }

        .stat-mini-icon {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .stat-mini-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-main);
        }

        .stat-mini-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-top: 2px;
        }

        /* ===== INFO CARD ===== */
        .info-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .info-card-header {
            padding: 16px 22px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card-title i {
            width: 28px;
            height: 28px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--primary);
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            background: var(--primary-light);
            color: var(--primary);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .edit-btn:hover {
            background: var(--primary);
            color: var(--white);
        }

        .info-rows {
            padding: 4px 0;
        }

        .info-row {
            display: flex;
            align-items: center;
            padding: 14px 22px;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            background: var(--bg-body);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--text-secondary);
            margin-right: 14px;
        }

        .info-row-content {
            flex: 1;
        }

        .info-row-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 2px;
        }

        .info-row-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
        }

        .info-row-value.mono {
            font-family: monospace;
            letter-spacing: 0.3px;
        }

        /* ===== CHANGE PASSWORD FORM ===== */
        .form-section {
            padding: 20px 22px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: block;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
            background: var(--bg-body);
            color: var(--text-main);
        }

        .form-input:focus {
            border-color: var(--primary);
            background: var(--white);
        }

        .form-input[readonly] {
            cursor: default;
            background: var(--bg-body);
            color: var(--text-secondary);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 4px;
        }

        .btn-primary {
            padding: 9px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            background: var(--primary);
            color: var(--white);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            padding: 9px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            background: transparent;
            color: var(--text-secondary);
            border: 1.5px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            border-color: var(--text-secondary);
            color: var(--text-main);
        }

        /* ===== ALERT ===== */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert i {
            font-size: 16px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center;
            padding: 20px 32px;
            font-size: 12.5px;
            color: var(--text-secondary);
            border-top: 1px solid var(--border-color);
            background: var(--white);
        }

        .page-footer span {
            color: var(--primary);
            font-weight: 700;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .content {
                padding: 20px 16px;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-brand,
            .topbar-divider,
            .member-chip {
                display: none;
            }

            .profile-hero {
                flex-direction: column;
                text-align: center;
                gap: 16px;
            }

            .profile-hero-poin {
                text-align: center;
            }

            .profile-hero-badges {
                justify-content: center;
            }

            .stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-row {
                grid-template-columns: 1fr;
            }
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
                    <i class="fas fa-chevron-down"
                        style="font-size:10px;color:rgba(255,255,255,0.5);margin-left:4px;"></i>

                    <div class="dropdown-menu-custom">
                        <a href="{{ route('member.profil') }}" class="dropdown-item-custom"
                            style="font-weight:700;color:var(--primary);">
                            <i class="fas fa-user" style="color:var(--primary)"></i> Profil Saya
                        </a>
                        <a href="{{ route('member.riwayat-transaksi') }}" class="dropdown-item-custom">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('member.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item-custom danger"
                                style="width:100%;border:none;background:none;cursor:pointer;text-align:left;">
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
                    <h1 class="page-title">Profil Saya</h1>
                    <p class="page-subtitle">Informasi akun dan pengaturan</p>
                </div>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Profile Hero --}}
            <div class="profile-hero">
                <div class="profile-avatar-lg">
                    {{ strtoupper(substr($user->name ?? $user->no_telepon, 0, 2)) }}
                </div>
                <div class="profile-hero-info">
                    <div class="profile-hero-name">{{ $user->name ?? 'Member' }}</div>
                    <div class="profile-hero-phone">
                        <i class="fas fa-phone"></i>
                        {{ $user->no_telepon }}
                    </div>
                    <div class="profile-hero-badges">
                        <span class="hero-badge member">
                            <i class="fas fa-id-card"></i>
                            Member Koperasi
                        </span>
                        <span class="hero-badge poin">
                            <i class="fas fa-coins"></i>
                            {{ number_format($user->saldo_poin, 0, ',', '.') }} Poin
                        </span>
                    </div>
                </div>
                <div class="profile-hero-poin">
                    <div class="poin-label-sm">SALDO POIN</div>
                    <div class="poin-big">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                    <div class="poin-unit-sm">poin aktif</div>
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="stats-row">
                <div class="stat-mini">
                    <div class="stat-mini-icon">🛒</div>
                    <div class="stat-mini-value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                    <div class="stat-mini-label">Total Transaksi</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-icon">📈</div>
                    <div class="stat-mini-value">{{ number_format($totalPoinMasuk, 0, ',', '.') }}</div>
                    <div class="stat-mini-label">Poin Masuk</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-icon">🎁</div>
                    <div class="stat-mini-value">{{ number_format($totalPenukaran, 0, ',', '.') }}</div>
                    <div class="stat-mini-label">Penukaran</div>
                </div>
            </div>

            {{-- Info Akun --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-title">
                        <i class="fas fa-user"></i>
                        Informasi Akun
                    </div>
                </div>
                <div class="info-rows">
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-user"></i></div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nama Lengkap</div>
                            <div class="info-row-value">{{ $user->name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-row-content">
                            <div class="info-row-label">Nomor Telepon</div>
                            <div class="info-row-value mono">{{ $user->no_telepon }}</div>
                        </div>
                    </div>
                    @if ($user->email)
                        <div class="info-row">
                            <div class="info-row-icon"><i class="fas fa-envelope"></i></div>
                            <div class="info-row-content">
                                <div class="info-row-label">Email</div>
                                <div class="info-row-value">{{ $user->email }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="info-row-content">
                            <div class="info-row-label">Bergabung Sejak</div>
                            <div class="info-row-value">{{ $user->created_at?->format('d F Y') ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-row-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="info-row-content">
                            <div class="info-row-label">Role</div>
                            <div class="info-row-value">
                                <span
                                    style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:100px;font-size:12px;font-weight:700;background:var(--primary-light);color:var(--primary);">
                                    <i class="fas fa-id-card" style="font-size:10px;"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ubah Profil --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-title">
                        <i class="fas fa-user-edit"></i>
                        Ubah Profil
                    </div>
                </div>
                <div class="form-section">
                    <form method="POST" action="{{ route('member.profil.update-profile') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-input"
                                value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="no_telepon">Nomor Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon" class="form-input"
                                value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 08123456789">
                            @error('no_telepon')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email <span
                                    style="font-weight:400;color:var(--text-secondary);">(opsional)</span></label>
                            <input type="email" id="email" name="email" class="form-input"
                                value="{{ old('email', $user->email) }}" placeholder="contoh@email.com">
                            @error('email')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn-secondary">Reset</button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-title">
                        <i class="fas fa-lock"></i>
                        Ubah Password
                    </div>
                </div>
                <div class="form-section">
                    <form method="POST" action="{{ route('member.profil.update-password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label" for="current_password">Password Lama</label>
                            <input type="password" id="current_password" name="current_password" class="form-input"
                                placeholder="Masukkan password lama" autocomplete="current-password">
                            @error('current_password')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;"><i
                                        class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="new_password">Password Baru</label>
                            <input type="password" id="new_password" name="new_password" class="form-input"
                                placeholder="Minimal 8 karakter" autocomplete="new-password">
                            @error('new_password')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;"><i
                                        class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="form-input" placeholder="Ulangi password baru" autocomplete="new-password">
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn-secondary">Reset</button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-card-title">
                        <i class="fas fa-link"></i>
                        Akses Cepat
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
                    <a href="{{ route('member.riwayat-poin') }}"
                        style="display:flex;align-items:center;gap:12px;padding:16px 22px;text-decoration:none;color:var(--text-main);border-bottom:1px solid var(--border-color);border-right:1px solid var(--border-color);transition:background 0.15s;"
                        onmouseover="this.style.background='var(--bg-body)'" onmouseout="this.style.background=''">
                        <div
                            style="width:36px;height:36px;background:rgba(16,185,129,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--success);flex-shrink:0;">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700;">Riwayat Poin</div>
                            <div style="font-size:12px;color:var(--text-secondary);">Lihat semua aktivitas poin</div>
                        </div>
                        <i class="fas fa-chevron-right"
                            style="margin-left:auto;font-size:11px;color:var(--text-secondary);"></i>
                    </a>
                    <a href="{{ route('member.riwayat-transaksi') }}"
                        style="display:flex;align-items:center;gap:12px;padding:16px 22px;text-decoration:none;color:var(--text-main);border-bottom:1px solid var(--border-color);transition:background 0.15s;"
                        onmouseover="this.style.background='var(--bg-body)'" onmouseout="this.style.background=''">
                        <div
                            style="width:36px;height:36px;background:var(--primary-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--primary);flex-shrink:0;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700;">Riwayat Transaksi</div>
                            <div style="font-size:12px;color:var(--text-secondary);">Semua histori belanja</div>
                        </div>
                        <i class="fas fa-chevron-right"
                            style="margin-left:auto;font-size:11px;color:var(--text-secondary);"></i>
                    </a>
                    <a href="{{ route('member.penukaran.index') }}"
                        style="display:flex;align-items:center;gap:12px;padding:16px 22px;text-decoration:none;color:var(--text-main);border-right:1px solid var(--border-color);transition:background 0.15s;"
                        onmouseover="this.style.background='var(--bg-body)'" onmouseout="this.style.background=''">
                        <div
                            style="width:36px;height:36px;background:rgba(255,202,10,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#a07800;flex-shrink:0;">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700;">Tukar Hadiah</div>
                            <div style="font-size:12px;color:var(--text-secondary);">Gunakan poin untuk hadiah</div>
                        </div>
                        <i class="fas fa-chevron-right"
                            style="margin-left:auto;font-size:11px;color:var(--text-secondary);"></i>
                    </a>
                    <a href="{{ route('member.dashboard') }}"
                        style="display:flex;align-items:center;gap:12px;padding:16px 22px;text-decoration:none;color:var(--text-main);transition:background 0.15s;"
                        onmouseover="this.style.background='var(--bg-body)'" onmouseout="this.style.background=''">
                        <div
                            style="width:36px;height:36px;background:rgba(59,130,246,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#3b82f6;flex-shrink:0;">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700;">Dashboard</div>
                            <div style="font-size:12px;color:var(--text-secondary);">Kembali ke halaman utama</div>
                        </div>
                        <i class="fas fa-chevron-right"
                            style="margin-left:auto;font-size:11px;color:var(--text-secondary);"></i>
                    </a>
                </div>
            </div>

        </main>

        <footer class="page-footer">
            © {{ date('Y') }} <span>Koperasi Pegawai UNAIR</span> · Semua hak dilindungi
        </footer>

    </div>
</body>

</html>
