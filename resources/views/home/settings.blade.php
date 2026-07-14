@extends('layouts.app')

@section('title', 'Pengaturan Sistem - Koperasi UNAIR')

@section('breadcrumb', 'Pages / Admin / Pengaturan')
@section('page-title', 'Pengaturan Sistem')

@push('styles')
    <style>
        .settings-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .settings-tab-btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid var(--border-color);
            background: var(--white);
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .settings-tab-btn.active,
        .settings-tab-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .settings-section {
            display: none;
        }

        .settings-section.active {
            display: block;
        }

        .settings-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .settings-card-header {
            padding: 20px 24px;
            border-bottom: 2px solid var(--bg-body);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .settings-card-header-icon {
            width: 44px;
            height: 44px;
            background: rgba(47, 50, 145, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .settings-card-body {
            padding: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-divider {
            height: 1px;
            background: var(--border-color);
            margin: 24px 0;
        }

        .avatar-circle {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 800;
            font-size: 28px;
            flex-shrink: 0;
            margin-bottom: 24px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e0;
            transition: 0.3s;
            border-radius: 28px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch input:checked+.toggle-slider {
            background-color: var(--primary);
        }

        .toggle-switch input:checked+.toggle-slider:before {
            transform: translateX(24px);
        }

        /* Alert box */
        .alert-success-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(34, 197, 94, 0.08);
            border-left: 4px solid #22c55e;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #15803d;
            font-weight: 600;
        }

        .username-hint {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .username-hint.valid {
            color: #22c55e;
        }

        .username-hint.invalid {
            color: var(--danger);
        }

        /* invalid field highlight */
        .form-control.is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')

    @php
        $showKeamanan =
            session('active_tab') === 'keamanan' || $errors->has('current_password') || $errors->has('new_password');
    @endphp
    {{-- ===================== TABS ===================== --}}
    <div class="settings-tabs">
        <button class="settings-tab-btn {{ !$showKeamanan ? 'active' : '' }}" onclick="switchTab('profil', this)">
            <i class="fas fa-user"></i> Profil Admin
        </button>
        <button class="settings-tab-btn {{ $showKeamanan ? 'active' : '' }}" onclick="switchTab('keamanan', this)">
            <i class="fas fa-lock"></i> Keamanan
        </button>
    </div>

    {{-- ===================== TAB: PROFIL ===================== --}}
    <div class="settings-section {{ !$showKeamanan ? 'active' : '' }}" id="tab-profil">
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-header-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div>
                    <h5 style="font-weight:700;color:var(--primary);margin:0;">Informasi Profil</h5>
                    <p style="font-size:13px;color:var(--text-secondary);margin:0;">Perbarui data diri dan informasi akun
                        Anda</p>
                </div>
            </div>
            <div class="settings-card-body">


                {{-- Flash sukses profil --}}
                @if (session('success_profile'))
                    <div class="alert-success-custom">
                        <i class="fas fa-check-circle" style="font-size:18px;"></i>
                        {{ session('success_profile') }}
                    </div>
                @endif

                <form method="POST"
                    action="{{ auth()->user()->role === 'admin' ? route('admin.settings.profile') : route('kasir.settings.profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        {{-- Nama --}}
                        <div class="form-group">
                            <label class="form-label required">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="form-group">
                            <label class="form-label required">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" id="usernameInput" value="{{ old('username', auth()->user()->username) }}"
                                placeholder="username_unik" autocomplete="off">
                            <p class="username-hint" id="usernameHint">
                                Hanya huruf, angka, <code>-</code> dan <code>_</code>. Tanpa spasi.
                            </p>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        {{-- Email --}}
                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email', auth()->user()->email) }}" placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control"
                                value="{{ ucfirst(auth()->user()->role ?? 'Admin') }}" readonly
                                style="background:var(--bg-body);cursor:not-allowed;">
                        </div>
                    </div>


                    <div style="display:flex;gap:12px;justify-content:flex-end;">
                        <button type="reset" class="btn"
                            style="border:2px solid var(--border-color);color:var(--text-secondary);">
                            <i class="fas fa-times"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== TAB: KEAMANAN ===================== --}}
    <div class="settings-section {{ $showKeamanan ? 'active' : '' }}" id="tab-keamanan">
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-header-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <h5 style="font-weight:700;color:var(--primary);margin:0;">Ubah Password</h5>
                    <p style="font-size:13px;color:var(--text-secondary);margin:0;">Gunakan password yang kuat dan unik</p>
                </div>
            </div>
            <div class="settings-card-body">

                {{-- Flash sukses password --}}
                @if (session('success_password'))
                    <div class="alert-success-custom">
                        <i class="fas fa-check-circle" style="font-size:18px;"></i>
                        {{ session('success_password') }}
                    </div>
                @endif

                <form method="POST"
                    action="{{ auth()->user()->role === 'admin' ? route('admin.settings.password') : route('kasir.settings.password') }}">
                    @csrf
                    @method('PUT')

                    {{-- Password lama --}}
                    <div class="form-group">
                        <label class="form-label required">Password Saat Ini</label>
                        <div style="position:relative;">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" id="currentPass" placeholder="Masukkan password lama">
                            <button type="button" onclick="togglePass('currentPass','eyeIcon1')"
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-secondary);">
                                <i class="fas fa-eye" id="eyeIcon1"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-row">
                        {{-- Password baru --}}
                        <div class="form-group">
                            <label class="form-label required">Password Baru</label>
                            <div style="position:relative;">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    name="new_password" id="newPass" placeholder="Min. 8 karakter">
                                <button type="button" onclick="togglePass('newPass','eyeIcon2')"
                                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-secondary);">
                                    <i class="fas fa-eye" id="eyeIcon2"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Konfirmasi --}}
                        <div class="form-group">
                            <label class="form-label required">Konfirmasi Password Baru</label>
                            <div style="position:relative;">
                                <input type="password" class="form-control" name="new_password_confirmation"
                                    id="confirmPass" placeholder="Ulangi password baru">
                                <button type="button" onclick="togglePass('confirmPass','eyeIcon3')"
                                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-secondary);">
                                    <i class="fas fa-eye" id="eyeIcon3"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Password strength indicator --}}
                    <div id="strengthBar"
                        style="height:6px;border-radius:4px;background:#e2e8f0;margin-bottom:16px;overflow:hidden;display:none;">
                        <div id="strengthFill"
                            style="height:100%;width:0%;transition:width 0.3s,background 0.3s;border-radius:4px;"></div>
                    </div>
                    <p id="strengthLabel" style="font-size:12px;margin-bottom:16px;display:none;"></p>

                    {{-- Info persyaratan --}}
                    <div
                        style="background:rgba(59,130,246,0.06);border-left:4px solid var(--info);padding:14px 18px;border-radius:8px;margin-bottom:20px;">
                        <p style="font-size:13px;color:var(--info);font-weight:600;margin:0 0 6px 0;">
                            <i class="fas fa-info-circle"></i> Persyaratan Password
                        </p>
                        <ul style="font-size:13px;color:var(--text-secondary);margin:0;padding-left:20px;line-height:1.8;">
                            <li id="req-len">Minimal 8 karakter</li>
                            <li id="req-case">Mengandung huruf besar dan kecil</li>
                            <li id="req-num">Mengandung minimal satu angka</li>
                            <li id="req-sym">Mengandung minimal satu karakter spesial (!@#$%)</li>
                        </ul>
                    </div>

                    <div style="display:flex;justify-content:flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shield-alt"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /* ── Tab switching ── */
        function switchTab(tab, btn) {
            document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.settings-tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            btn.classList.add('active');
        }

        /* ── Show/hide password ── */
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        /* ── Username live validation ── */
        const usernameInput = document.getElementById('usernameInput');
        const usernameHint = document.getElementById('usernameHint');
        const validPattern = /^[a-zA-Z0-9_-]+$/;

        usernameInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val === '') {
                usernameHint.textContent = 'Hanya huruf, angka, - dan _. Tanpa spasi.';
                usernameHint.className = 'username-hint';
            } else if (!validPattern.test(val)) {
                usernameHint.textContent = '✗ Username mengandung karakter tidak valid atau spasi.';
                usernameHint.className = 'username-hint invalid';
            } else if (val.length < 3) {
                usernameHint.textContent = '✗ Username minimal 3 karakter.';
                usernameHint.className = 'username-hint invalid';
            } else {
                usernameHint.textContent = '✓ Format username valid.';
                usernameHint.className = 'username-hint valid';
            }
        });

        /* ── Password strength indicator ── */
        const newPassInput = document.getElementById('newPass');
        const strengthBar = document.getElementById('strengthBar');
        const strengthFill = document.getElementById('strengthFill');
        const strengthLabel = document.getElementById('strengthLabel');
        const reqLen = document.getElementById('req-len');
        const reqCase = document.getElementById('req-case');
        const reqNum = document.getElementById('req-num');
        const reqSym = document.getElementById('req-sym');

        newPassInput.addEventListener('input', function() {
            const val = this.value;
            if (val.length === 0) {
                strengthBar.style.display = 'none';
                strengthLabel.style.display = 'none';
                resetReqs();
                return;
            }
            strengthBar.style.display = 'block';
            strengthLabel.style.display = 'block';

            const hasLen = val.length >= 8;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasNum = /[0-9]/.test(val);
            const hasSym = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(val);

            markReq(reqLen, hasLen);
            markReq(reqCase, hasUpper && hasLower);
            markReq(reqNum, hasNum);
            markReq(reqSym, hasSym);

            const score = [hasLen, hasUpper && hasLower, hasNum, hasSym].filter(Boolean).length;
            const levels = [{
                    w: '25%',
                    bg: '#ef4444',
                    label: 'Sangat Lemah'
                },
                {
                    w: '50%',
                    bg: '#f97316',
                    label: 'Lemah'
                },
                {
                    w: '75%',
                    bg: '#eab308',
                    label: 'Sedang'
                },
                {
                    w: '100%',
                    bg: '#22c55e',
                    label: 'Kuat'
                },
            ];
            const lvl = levels[score - 1] || levels[0];
            strengthFill.style.width = lvl.w;
            strengthFill.style.background = lvl.bg;
            strengthLabel.textContent = 'Kekuatan: ' + lvl.label;
            strengthLabel.style.color = lvl.bg;
        });

        function markReq(el, ok) {
            el.style.color = ok ? '#22c55e' : 'var(--text-secondary)';
            el.style.fontWeight = ok ? '600' : '400';
        }

        function resetReqs() {
            [reqLen, reqCase, reqNum, reqSym].forEach(el => {
                el.style.color = 'var(--text-secondary)';
                el.style.fontWeight = '400';
            });
        }
    </script>
@endpush
