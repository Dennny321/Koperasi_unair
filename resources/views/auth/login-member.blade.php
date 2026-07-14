<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Member — Koperasi Pegawai UNAIR</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
            --danger:         #ef4444;
            --transition:     all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-body);
        }

        .wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ─── LEFT PANEL ─── */
        .left-panel {
            background: linear-gradient(160deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 56px;
            position: relative;
            overflow: hidden;
        }

        .blob-1 {
            position: absolute;
            width: 380px; height: 380px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            top: -120px; right: -120px;
        }
        .blob-2 {
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -60px; left: -80px;
        }
        .blob-3 {
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255, 202, 10, 0.08);
            bottom: 200px; right: 60px;
        }

        /* Logo */
        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
            z-index: 1;
        }

        .logo-box {
            min-width: 48px; height: 48px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            padding: 7px; flex-shrink: 0;
        }

        .logo-img { width: 100%; height: 100%; object-fit: contain; }

        .logo-text {
            font-weight: 800;
            font-size: 16px;
            color: var(--white);
            line-height: 1.3;
        }

        .logo-text span { color: var(--accent); }

        /* Hero tag */
        .hero-tag {
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 202, 10, 0.15);
            border: 1px solid rgba(255, 202, 10, 0.3);
            border-radius: 100px;
            padding: 6px 14px;
            margin-bottom: 24px;
        }

        .hero-tag .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--accent);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-tag span {
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.8px;
        }

        .hero-heading {
            z-index: 1;
            font-size: 36px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-heading em {
            font-style: normal;
            color: var(--accent);
        }

        .hero-desc {
            z-index: 1;
            font-size: 14.5px;
            color: rgba(255,255,255,0.65);
            line-height: 1.75;
            max-width: 360px;
            margin-bottom: 48px;
        }

        /* Features */
        .features { z-index: 1; display: flex; flex-direction: column; gap: 16px; }

        .feature-item { display: flex; align-items: center; gap: 12px; }

        .feature-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(255, 202, 10, 0.12);
            border: 1px solid rgba(255, 202, 10, 0.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon svg { width: 17px; height: 17px; stroke: var(--accent); }

        .feature-text { font-size: 14px; color: rgba(255,255,255,0.75); }

        /* ─── RIGHT PANEL ─── */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: var(--white);
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            animation: slide-up 0.45s ease forwards;
        }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-secondary);
            font-size: 13px;
            text-decoration: none;
            margin-bottom: 36px;
            transition: var(--transition);
        }

        .back-link:hover { color: var(--primary); }
        .back-link svg { width: 14px; height: 14px; stroke: currentColor; }

        /* Form header */
        .form-header { margin-bottom: 32px; }

        .member-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            border: 1px solid rgba(47, 50, 145, 0.15);
            border-radius: 100px;
            padding: 5px 13px;
            margin-bottom: 16px;
        }

        .member-badge svg { width: 14px; height: 14px; stroke: var(--primary); }

        .member-badge span {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: 0.5px;
        }

        .form-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.25;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.65;
        }

        /* Form fields */
        .field-group { margin-bottom: 20px; }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 7px;
        }

        .field-wrapper { position: relative; }

        .field-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            width: 17px; height: 17px;
            stroke: var(--text-secondary);
            pointer-events: none;
            transition: stroke 0.2s;
        }

        .field-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-main);
            background: var(--bg-body);
            transition: var(--transition);
            outline: none;
        }

        .field-input::placeholder { color: #b0bec5; }

        .field-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(47, 50, 145, 0.1);
        }

        .field-wrapper:focus-within .field-icon { stroke: var(--primary); }

        .field-input.is-invalid {
            border-color: var(--danger);
            background: #fff5f5;
        }

        .field-error {
            margin-top: 6px;
            font-size: 12.5px;
            color: var(--danger);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; padding: 2px;
            color: var(--text-secondary);
            display: flex; align-items: center;
            transition: color 0.2s;
        }

        .toggle-pw:hover { color: var(--primary); }
        .toggle-pw svg { width: 17px; height: 17px; }

        /* Remember */
        .remember-row {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
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
            width: 16px; height: 16px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            background: var(--white);
            cursor: pointer;
            position: relative;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .check-label input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .check-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 1px; left: 4px;
            width: 5px; height: 8px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(40deg);
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(47, 50, 145, 0.3);
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-submit:hover::before { opacity: 1; }
        .btn-submit:hover { box-shadow: 0 6px 20px rgba(47, 50, 145, 0.4); transform: translateY(-1px); }
        .btn-submit:active { transform: scale(0.98); }

        /* Accent underline stripe on button */
        .btn-submit-wrapper::after {
            content: '';
            display: block;
            height: 3px;
            background: var(--accent);
            border-radius: 0 0 10px 10px;
            margin-top: -3px;
            opacity: 0.8;
        }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0;
        }

        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: var(--border-color);
        }

        .divider span { font-size: 12px; color: var(--text-secondary); white-space: nowrap; }

        /* Register box */
        .register-box {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .register-box p { font-size: 13.5px; color: var(--text-secondary); margin-bottom: 4px; }

        .register-box a {
            color: var(--primary);
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-box a:hover { color: var(--primary-dark); text-decoration: underline; }

        /* Admin link */
        .admin-link { text-align: center; margin-top: 20px; }

        .admin-link a {
            font-size: 12.5px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .admin-link a:hover { color: var(--primary); }

        /* Alert error */
        .alert-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-left: 4px solid var(--danger);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 13.5px;
            color: #b91c1c;
            display: flex; gap: 10px;
        }

        .alert-error svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }

        /* Responsive */
        @media (max-width: 768px) {
            .wrapper     { grid-template-columns: 1fr; }
            .left-panel  { display: none; }
            .right-panel { padding: 40px 24px; }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- ─── LEFT PANEL ─── -->
        <div class="left-panel">
            <div class="blob-1"></div>
            <div class="blob-2"></div>
            <div class="blob-3"></div>

            <div class="logo-area">
                <div class="logo-box">
                    <img src="{{ asset('images/unair-logo.png') }}" alt="UNAIR" class="logo-img">
                </div>
                <div class="logo-text">
                    KOPERASI<span><br>UNAIR</span>
                </div>
            </div>

            <div class="hero-tag">
                <div class="dot"></div>
                <span>MEMBER AREA</span>
            </div>

            <h1 class="hero-heading">
                Selamat datang<br>di <em>Portal Member</em><br>Koperasi
            </h1>

            <p class="hero-desc">
                Pantau poin reward, cek riwayat transaksi, dan nikmati berbagai keuntungan eksklusif sebagai member Koperasi Pegawai UNAIR.
            </p>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                        </svg>
                    </div>
                    <span class="feature-text">Riwayat transaksi real-time</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <span class="feature-text">Cek & tukar saldo poin reward</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="feature-text">Katalog hadiah eksklusif member</span>
                </div>
            </div>
        </div>

        <!-- ─── RIGHT PANEL ─── -->
        <div class="right-panel">
            <div class="form-container">

                <!-- <a href="{{ route('login') }}" class="back-link">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Login Pegawai
                </a> -->

                <div class="form-header">
                    <div class="member-badge">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>MEMBER LOGIN</span>
                    </div>
                    <h2 class="form-title">Masuk ke Akun<br>Member Anda</h2>
                    <p class="form-subtitle">Gunakan nomor telepon yang terdaftar sebagai member koperasi.</p>
                </div>

                {{-- Alert error global --}}
                @if ($errors->any() && !$errors->has('no_telepon') && !$errors->has('password'))
                    <div class="alert-error">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg" style="stroke:#b91c1c">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('member.login.post') }}">
                    @csrf

                    {{-- Nomor Telepon --}}
                    <div class="field-group">
                        <label for="no_telepon" class="field-label">Nomor Telepon</label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <input
                                id="no_telepon"
                                type="number"
                                name="no_telepon"
                                value="{{ old('no_telepon') }}"
                                class="field-input {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}"
                                placeholder="Contoh: 081234567890"
                                required
                                autocomplete="tel"
                                autofocus
                            >
                        </div>
                        @error('no_telepon')
                            <div class="field-error">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px;stroke:#ef4444;flex-shrink:0">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field-group">
                        <label for="password" class="field-label">Kata Sandi</label>
                        <div class="field-wrapper">
                            <svg class="field-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="field-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="Masukkan kata sandi"
                                required
                                autocomplete="current-password"
                                style="padding-right: 42px;"
                            >
                            <button type="button" class="toggle-pw" onclick="togglePassword()" title="Tampilkan / sembunyikan kata sandi">
                                <svg id="eye-show" fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-hide" fill="none" viewBox="0 0 24 24" stroke-width="1.8" xmlns="http://www.w3.org/2000/svg" style="display:none">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px;stroke:#ef4444;flex-shrink:0">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="btn-submit-wrapper">
                        <button type="submit" class="btn-submit">
                            Masuk ke Akun Member
                        </button>
                    </div>
                </form>

                <!-- <div class="admin-link">
                    <a href="{{ route('login') }}">Masuk sebagai Pegawai / Admin</a>
                </div> -->

            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input   = document.getElementById('password');
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