@extends('layouts.app')

@section('title', 'Tambah Hadiah')
@section('breadcrumb', 'Master / Hadiah / Tambah')
@section('page-title', 'Tambah Hadiah Baru')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah Hadiah Baru</h2>
        <p style="color: var(--text-secondary);">Lengkapi form di bawah untuk menambah hadiah</p>
    </div>
    <a href="{{ route('admin.hadiah.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Hadiah</h3>
    </div>

    <form action="{{ route('admin.hadiah.store') }}" method="POST">
        @csrf

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group">
                        <label class="form-label required">Nama Hadiah</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama hadiah" required>
                        @error('nama')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Biaya Poin</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);">
                                <i class="fas fa-coins"></i>
                            </span>
                            <input type="number" name="biaya_poin" class="form-control @error('biaya_poin') is-invalid @enderror" value="{{ old('biaya_poin', 0) }}" placeholder="0" min="0" required style="padding-left: 40px;">
                        </div>
                        @error('biaya_poin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Jumlah poin yang dibutuhkan untuk menukar hadiah ini</small>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="form-group">
                        <label class="form-label required">Stok</label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}" placeholder="0" min="0" required>
                        @error('stok')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Jumlah hadiah yang tersedia untuk ditukar</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="aktif" class="form-control @error('aktif') is-invalid @enderror" required>
                            <option value="1" {{ old('aktif', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('aktif')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Hadiah aktif dapat ditukar oleh member</small>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div style="margin-top: 24px; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-info-circle" style="font-size: 24px;"></i>
                    <div>
                        <p style="margin: 0; font-weight: 600; font-size: 15px;">Informasi Penting</p>
                        <p style="margin: 4px 0 0; font-size: 13px; opacity: 0.9;">
                            Hadiah hanya dapat ditukar oleh member jika status <strong>Aktif</strong> dan <strong>Stok tersedia</strong> (> 0).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    Simpan Hadiah
                </button>
                <a href="{{ route('admin.hadiah.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection