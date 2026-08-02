@extends('layouts.app')

@section('title', 'Tambah User')
@section('breadcrumb', 'Admin / User / Tambah')
@section('page-title', 'Tambah User')

@section('content')
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah User Baru</h2>
            <p style="color: var(--text-secondary);">Lengkapi formulir di bawah untuk menambah akun pengguna</p>
        </div>
        <a href="{{ route('admin.user.index') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah User</h3>
        </div>

        <form action="{{ route('admin.user.store') }}" method="POST" id="userForm">
            @csrf

            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">

                    {{-- ── KOLOM KIRI ── --}}
                    <div>

                        {{-- Nama --}}
                        <div class="form-group">
                            <label class="form-label required">Nama Lengkap</label>
                            <div style="position: relative;">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap" autocomplete="off" required>
                                <span id="name-spinner" class="field-spinner" style="display:none;">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" style="display:block;">{{ $message }}</span>
                            @enderror
                            <div id="name-feedback" class="duplicate-feedback"></div>
                        </div>

                        {{-- Username --}}
                        <div class="form-group">
                            <label class="form-label required">Username</label>
                            <div style="position: relative;">
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" placeholder="Contoh: john_doe" autocomplete="off" required>
                                <span id="username-spinner" class="field-spinner" style="display:none;">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </div>
                            @error('username')
                                <span class="invalid-feedback" style="display:block;">{{ $message }}</span>
                            @enderror
                            <div id="username-feedback" class="duplicate-feedback"></div>
                            <small style="color: var(--text-secondary); font-size: 11px; margin-top: 4px; display:block;">
                                Hanya huruf, angka, tanda hubung (-) dan garis bawah (_). Tanpa spasi.
                            </small>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <div style="position: relative;">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="email@example.com" autocomplete="off" required>
                                <span id="email-spinner" class="field-spinner" style="display:none;">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" style="display:block;">{{ $message }}</span>
                            @enderror
                            <div id="email-feedback" class="duplicate-feedback"></div>
                        </div>

                        {{-- No. Telepon --}}
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <div style="position: relative;">
                                <input type="text" name="no_telepon" id="no_telepon"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    value="{{ old('no_telepon') }}" placeholder="Contoh: 081234567890" autocomplete="off">
                                <span id="no_telepon-spinner" class="field-spinner" style="display:none;">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                            </div>
                            @error('no_telepon')
                                <span class="invalid-feedback" style="display:block;">{{ $message }}</span>
                            @enderror
                            <div id="no_telepon-feedback" class="duplicate-feedback"></div>
                        </div>

                    </div>

                    {{-- ── KOLOM KANAN ── --}}
                    <div>

                        {{-- Role --}}
                        <div class="form-group">
                            <label class="form-label required">Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required
                                id="roleSelect" onchange="toggleRoleInfo()">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label class="form-label required">Password</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 8 karakter" required>
                                <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; cursor:pointer; color:var(--text-secondary);">
                                    <i class="fas fa-eye" id="eyeIcon1"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">
                            <label class="form-label required">Konfirmasi Password</label>
                            <div style="position: relative;">
                                <input type="password" name="password_confirmation" id="passwordConfirm"
                                    class="form-control" placeholder="Ulangi password" required>
                                <button type="button" onclick="togglePassword('passwordConfirm', 'eyeIcon2')"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; cursor:pointer; color:var(--text-secondary);">
                                    <i class="fas fa-eye" id="eyeIcon2"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Info Role --}}
                <div id="roleInfo"
                    style="display:none; background: var(--bg-body); border: 1px solid var(--border-color);
                border-radius: var(--radius); padding: 14px 18px; margin-top: 8px;">
                    <div id="roleInfoContent" style="font-size: 13px; color: var(--text-secondary);"></div>
                </div>

                {{-- Buttons --}}
                <div
                    style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan User
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>

    @push('styles')
        <style>
            .field-spinner {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--text-secondary);
                pointer-events: none;
            }

            .duplicate-feedback { font-size: 12px; margin-top: 5px; min-height: 18px; }
            .duplicate-feedback.is-duplicate { color: #dc3545; }
            .duplicate-feedback.is-available { color: #28a745; }
            .form-control.input-duplicate {
                border-color: #dc3545;
                box-shadow: 0 0 0 2px rgba(220, 53, 69, .15);
            }
            .form-control.input-available {
                border-color: #28a745;
                box-shadow: 0 0 0 2px rgba(40, 167, 69, .12);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const CHECK_URL = "{{ route('admin.user.check-duplicate') }}";
            const IGNORE_ID = null;

            const FIELDS = [
                { id: 'name',       label: 'Nama' },
                { id: 'username',   label: 'Username' },
                { id: 'email',      label: 'Email' },
                { id: 'no_telepon', label: 'Nomor telepon' },
            ];

            function debounce(fn, ms) {
                let timer;
                return (...args) => { clearTimeout(timer); timer = setTimeout(() => fn(...args), ms); };
            }

            FIELDS.forEach(({ id, label }) => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('input', debounce(() => checkField(id, label), 500));
                el.addEventListener('blur', () => checkField(id, label));
            });

            document.getElementById('userForm').addEventListener('submit', function(e) {
                const hasDuplicate = FIELDS.some(({ id }) => {
                    const input = document.getElementById(id);
                    return input && input.classList.contains('input-duplicate');
                });
                if (hasDuplicate) {
                    e.preventDefault();
                    alert('Terdapat data yang sudah digunakan. Periksa kembali sebelum menyimpan.');
                }
            });

            const roleDescriptions = {
                admin: '<i class="fas fa-shield-alt" style="color:#dc3545;"></i> <strong>Admin</strong> — akses penuh ke seluruh sistem termasuk manajemen user dan laporan.',
                kasir: '<i class="fas fa-cash-register" style="color:#fd7e14;"></i> <strong>Kasir</strong> — dapat melakukan transaksi penjualan dan melihat laporan terbatas.',
            };

            function toggleRoleInfo() {
                const role = document.getElementById('roleSelect').value;
                const info = document.getElementById('roleInfo');
                const content = document.getElementById('roleInfoContent');

                if (role && roleDescriptions[role]) {
                    info.style.display = 'block';
                    content.innerHTML = roleDescriptions[role];
                } else {
                    info.style.display = 'none';
                }
            }

            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            }

            document.addEventListener('DOMContentLoaded', toggleRoleInfo);
        </script>
    @endpush
@endsection