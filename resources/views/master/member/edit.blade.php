@extends('layouts.app')

@section('title', 'Edit Member')
@section('breadcrumb', 'Master / Member / Edit')
@section('page-title', 'Edit Data Member')

@push('styles')
<style>
    .password-section {
        background: rgba(47, 50, 145, 0.03);
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .password-section-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .password-section-title i {
        color: var(--primary);
    }
    .password-hint {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .toggle-pass-btn {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-secondary);
        padding: 0;
        font-size: 14px;
    }
    .toggle-pass-btn:hover {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
@php $prefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp

<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Edit Data Member </h2>
        <p style="color: var(--text-secondary);">Perbarui informasi member</p>
    </div>
    <a href="{{ route($prefix.'.member.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Member</h3>
    </div>

    <form action="{{ route($prefix.'.member.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="padding: 24px; max-width: 100%;">

            {{-- Informasi Dasar --}}
            <div class="form-group">
                <label class="form-label required">Nama Lengkap</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $member->name) }}"
                    placeholder="Masukkan nama lengkap member">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label required">No. Telepon</label>
                <input type="text" name="no_telepon"
                    class="form-control @error('no_telepon') is-invalid @enderror"
                    value="{{ old('no_telepon', $member->no_telepon) }}"
                    placeholder="Contoh: 08123456789">
                @error('no_telepon')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Section Reset Password --}}
            <div class="password-section">
                <div class="password-section-title">
                    <i class="fas fa-key"></i>
                    Reset Password <span style="font-weight:400;font-size:12px;">(kosongkan jika tidak ingin mengubah)</span>
                </div>

                <div class="form-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Password Baru</label>
                        <div style="position: relative;">
                            <input type="password" name="new_password" id="newPass"
                                class="form-control @error('new_password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password">
                            <button type="button" class="toggle-pass-btn" onclick="togglePass('newPass', 'eyeIcon1')">
                                <i class="fas fa-eye" id="eyeIcon1"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p class="password-hint">
                            <i class="fas fa-info-circle"></i>
                            Biarkan kosong jika tidak ingin mengubah password.
                        </p>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div style="position: relative;">
                            <input type="password" name="new_password_confirmation" id="confirmPass"
                                class="form-control"
                                placeholder="Ulangi password baru"
                                autocomplete="new-password">
                            <button type="button" class="toggle-pass-btn" onclick="togglePass('confirmPass', 'eyeIcon2')">
                                <i class="fas fa-eye" id="eyeIcon2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Quick reset ke no telepon --}}
                <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-color);">
                    <p style="font-size: 12.5px; color: var(--text-secondary); margin-bottom: 0; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-lightbulb" style="color: var(--warning);"></i>
                        Atau gunakan tombol berikut untuk reset password ke nomor telepon member:
                        <button type="button" onclick="fillResetToPhone()"
                            class="btn btn-sm"
                            style="border: 1.5px solid var(--warning); color: var(--warning); background: rgba(245,158,11,0.06); margin-left: 4px;">
                            <i class="fas fa-rotate-left"></i> Reset ke No. Telepon
                        </button>
                    </p>
                </div>
            </div>

            {{-- Buttons --}}
            <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route($prefix.'.member.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Isi otomatis password = no_telepon yang sedang diisi di form
    function fillResetToPhone() {
        const noTelepon = document.querySelector('input[name="no_telepon"]').value.trim();
        if (!noTelepon) {
            alert('Isi nomor telepon terlebih dahulu.');
            return;
        }
        document.getElementById('newPass').value     = noTelepon;
        document.getElementById('confirmPass').value = noTelepon;
    }
</script>
@endpush