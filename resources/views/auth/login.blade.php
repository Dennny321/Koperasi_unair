<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin — Koperasi Pegawai UNAIR</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap"
        rel="stylesheet">
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
            --danger: #ef4444;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html,
        body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
        }

        /* ─── WRAPPER: split layout ─── */
        .wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ══════════════════════════════
           LEFT PANEL  (visual / branding)
        ══════════════════════════════ */
        .left-panel {
            background: linear-gradient(155deg, var(--primary-dark) 0%, var(--primary) 60%, #3d3fa8 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 56px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative geometry */
        .geo {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .geo-1 {
            width: 420px;
            height: 420px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            top: -140px;
            right: -140px;
        }

        .geo-2 {
            width: 280px;
            height: 280px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            top: -40px;
            right: -40px;
        }

        .geo-3 {
            width: 300px;
            height: 300px;
            background: rgba(255, 202, 10, 0.06);
            bottom: -80px;
            left: -80px;
        }

        .geo-4 {
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.03);
            bottom: 160px;
            right: 40px;
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        /* Logo */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 1;
        }

        .logo-box {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            flex-shrink: 0;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-text {
            font-weight: 800;
            font-size: 17px;
            color: var(--white);
            line-height: 1.3;
        }

        .logo-text span {
            color: var(--accent);
        }

        /* Center hero block */
        .hero-block {
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 0 40px;
        }

        /* Admin badge */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 202, 10, 0.12);
            border: 1px solid rgba(255, 202, 10, 0.25);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 28px;
            width: fit-content;
        }

        .shield-icon {
            width: 16px;
            height: 16px;
            stroke: var(--accent);
            fill: none;
        }

        .admin-badge span {
            font-size: 11.5px;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: 1.2px;
        }

        .hero-heading {
            font-size: 38px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.18;
            margin-bottom: 20px;
        }

        .hero-heading em {
            font-style: normal;
            color: var(--accent);
        }

        .hero-desc {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            max-width: 340px;
            margin-bottom: 44px;
        }

        /* Stat cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 16px;
        }

        .stat-card .stat-val {
            font-size: 22px;
            font-weight: 800;
            color: var(--white);
            display: block;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
        }

        .stat-card .stat-accent {
            color: var(--accent);
        }

        /* Bottom footer text */
        .left-footer {
            z-index: 1;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
        }

        /* ══════════════════════════════
           RIGHT PANEL  (form)
        ══════════════════════════════ */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 44px;
            background: var(--white);
            position: relative;
        }

        /* Subtle top accent bar */
        .right-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            animation: fade-up 0.45s ease forwards;
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form header */
        .form-header {
            margin-bottom: 32px;
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            border: 1px solid rgba(47, 50, 145, 0.15);
            border-radius: 100px;
            padding: 5px 13px;
            margin-bottom: 18px;
        }

        .role-pill svg {
            width: 13px;
            height: 13px;
            stroke: var(--primary);
            fill: none;
        }

        .role-pill span {
            font-size: 11.5px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 0.8px;
        }

        .form-title {
            font-size: 27px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.65;
        }

        /* Alert error */
        .alert-error {
            background: rgba(239, 68, 68, 0.07);
            border: 1px solid rgba(239, 68, 68, 0.18);
            border-left: 4px solid var(--danger);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 13.5px;
            color: #b91c1c;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .alert-error svg {
            width: 16px;
            height: 16px;
            stroke: #b91c1c;
            fill: none;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Field group */
        .field-group {
            margin-bottom: 20px;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 7px;
        }

        .field-wrapper {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            stroke: var(--text-secondary);
            fill: none;
            pointer-events: none;
            transition: stroke 0.2s;
        }

        .field-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-main);
            background: var(--bg-body);
            transition: var(--transition);
            outline: none;
        }

        .field-input::placeholder {
            color: #b0bec5;
        }

        .field-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(47, 50, 145, 0.1);
        }

        .field-wrapper:focus-within .field-icon {
            stroke: var(--primary);
        }

        .field-input.is-invalid {
            border-color: var(--danger);
            background: #fff5f5;
        }

        .field-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .field-error {
            margin-top: 6px;
            font-size: 12.5px;
            color: var(--danger);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .field-error svg {
            width: 12px;
            height: 12px;
            stroke: var(--danger);
            fill: none;
            flex-shrink: 0;
        }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-pw:hover {
            color: var(--primary);
        }

        .toggle-pw svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
        }

        /* Options row */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 26px;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13.5px;
            color: var(--text-secondary);
            user-select: none;
        }

        .check-label input[type="checkbox"] {
            appearance: none;
            width: 17px;
            height: 17px;
            border: 2px solid var(--border-color);
            border-radius: 5px;
            background: var(--white);
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .check-label input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .check-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 4px;
            width: 5px;
            height: 8px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(43deg);
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(47, 50, 145, 0.32);
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit svg {
            width: 18px;
            height: 18px;
            stroke: var(--white);
            fill: none;
            transition: transform 0.2s;
        }

        .btn-submit:hover {
            box-shadow: 0 6px 24px rgba(47, 50, 145, 0.42);
            transform: translateY(-1px);
        }

        .btn-submit:hover svg {
            transform: translateX(3px);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Accent stripe below button */
        .btn-accent-stripe {
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            border-radius: 0 0 10px 10px;
            margin-top: -2px;
            opacity: 0.85;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 18px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .divider span {
            font-size: 12px;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        /* Member link box */
        .member-box {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .member-box p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .member-box p strong {
            color: var(--text-main);
            display: block;
            margin-bottom: 2px;
        }

        .member-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            white-space: nowrap;
            transition: gap 0.2s;
        }

        .member-link:hover {
            gap: 8px;
            color: var(--primary-dark);
        }

        .member-link svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        /* Footer note */
        .form-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .form-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .wrapper {
                grid-template-columns: 1fr;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                padding: 40px 24px;
            }

            .right-panel::before {
                height: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- ════════ LEFT PANEL ════════ -->
        <div class="left-panel">
            <div class="grid-overlay"></div>
            <div class="geo geo-1"></div>
            <div class="geo geo-2"></div>
            <div class="geo geo-3"></div>
            <div class="geo geo-4"></div>

            <!-- Logo -->
            <div class="logo-area">
                <div class="logo-box">
                    <img src="{{ asset('images/unair-logo.png') }}" alt="UNAIR" class="logo-img">
                </div>
                <div class="logo-text">
                    KOPERASI<span><br>UNAIR</span>
                </div>
            </div>

            <!-- Hero -->
            <div class="hero-block">
                <div class="admin-badge">
                    <svg class="shield-icon" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>ADMIN PANEL</span>
                </div>

                <h1 class="hero-heading">
                    Panel Kontrol<br>
                    <em>Administrator</em><br>
                    Koperasi
                </h1>

                <p class="hero-desc">
                    Kelola seluruh data koperasi — transaksi, produk, hadiah, dan member — dari satu dashboard terpusat
                    yang aman.
                </p>

                <div class="stats-row">
                    <div class="stat-card">
                        <span class="stat-val stat-accent">100%</span>
                        <span class="stat-label">Akses Penuh</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-val">Data</span>
                        <span class="stat-label">Real-time</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-val">🔐</span>
                        <span class="stat-label">Terenkripsi</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="left-footer">
                © {{ date('Y') }} Koperasi Pegawai Universitas Airlangga
            </div>
        </div>

        <!-- ════════ RIGHT PANEL ════════ -->
        <div class="right-panel">
            <div class="form-container">

                <!-- Header -->
                <div class="form-header">
                    <div class="role-pill">
                        <svg viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>ADMINISTRATOR/KASIR</span>
                    </div>
                    <h2 class="form-title">Masuk ke<br>Halaman Pegawai</h2>
                    <p class="form-subtitle">Gunakan <strong>username</strong> atau email untuk login sebagai
                        pegawai.</p>
                </div>

                {{-- Alert error --}}
                @if ($errors->any())
                    <div class="alert-error">
                        <svg viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    {{-- Identifier (nama / email) --}}
                    <div class="field-group">
                        <label for="identifier" class="field-label">Username</label>
                        <div class="field-wrapper">
                            <svg class="field-icon" viewBox="0 0 24 24" stroke-width="1.8"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}"
                                class="field-input {{ $errors->has('identifier') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan username" required autocomplete="username" autofocus>
                        </div>
                        @error('identifier')
                            <div class="field-error">
                                <svg viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field-group">
                        <label for="password" class="field-label">Kata Sandi</label>
                        <div class="field-wrapper">
                            <svg class="field-icon" viewBox="0 0 24 24" stroke-width="1.8"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password"
                                class="field-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan kata sandi" required autocomplete="current-password"
                                style="padding-right: 44px;">
                            <button type="button" class="toggle-pw" onclick="togglePassword()"
                                title="Tampilkan / sembunyikan">
                                <svg id="eye-show" viewBox="0 0 24 24" stroke-width="1.8"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-hide" viewBox="0 0 24 24" stroke-width="1.8"
                                    xmlns="http://www.w3.org/2000/svg" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error">
                                <svg viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    {{-- Submit --}}
                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk
                    </button>
                    <div class="btn-accent-stripe"></div>
                </form>

                <div class="divider">
                    <span>bukan pegawai?</span>
                </div>

                <!-- Link ke member login -->
                <div class="member-box">
                    <p>
                        <strong>Login Member</strong>
                        Gunakan nomor telepon terdaftar
                    </p>
                    <a href="{{ route('member.login') }}" class="member-link">
                        Masuk
                        <svg viewBox="0 0 24 24" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeShow = document.getElementById('eye-show');
            const eyeHide = document.getElementById('eye-hide');

            if (input.type === 'password') {
                input.type = 'text';
                eyeShow.style.display = 'none';
                eyeHide.style.display = 'block';
            } else {
                input.type = 'password';
                eyeShow.style.display = 'block';
                eyeHide.style.display = 'none';
            }
        }
    </script>
</body>

</html>
