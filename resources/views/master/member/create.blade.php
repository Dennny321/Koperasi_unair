@extends('layouts.app')

@section('title', 'Tambah Member')
@section('breadcrumb', 'Master / Member / Tambah')
@section('page-title', 'Tambah Member Baru')

@section('content')
@php $prefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah Member Baru ➕</h2>
        <p style="color: var(--text-secondary);">Daftarkan member baru koperasi</p>
    </div>
    <a href="{{ route($prefix.'.member.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Member</h3>
    </div>

    <form action="{{ route($prefix.'.member.store') }}" method="POST">
        @csrf

        <div style="padding: 24px; max-width: 100%;">

            <div class="form-group">
                <label class="form-label required">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap member" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label required">No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}" placeholder="Contoh: 08123456789" required>
                @error('no_telepon')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small style="color: var(--text-secondary); font-size: 12px; margin-top: 4px; display: block;">
                    <i class="fas fa-info-circle"></i> Password member akan otomatis diset sama dengan nomor telepon.
                </small>
            </div>

            <div style="background: var(--bg-body); border-radius: 10px; padding: 16px; margin-bottom: 24px; border-left: 4px solid var(--primary);">
                <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">
                    <i class="fas fa-shield-alt" style="color: var(--primary);"></i>
                    <strong style="color: var(--text-main);">Info Login Member:</strong>
                    Member dapat login menggunakan <strong>No. Telepon</strong> sebagai username dan password awal.
                    Password dapat diubah oleh admin melalui halaman detail member.
                </p>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    Simpan Member
                </button>
                <a href="{{ route($prefix.'.member.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection