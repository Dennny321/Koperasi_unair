@extends('layouts.app')

@section('title', 'Edit Hadiah')
@section('breadcrumb', 'Master / Hadiah / Edit')
@section('page-title', 'Edit Hadiah')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Edit Hadiah</h2>
        <p style="color: var(--text-secondary);">Perbarui informasi hadiah</p>
    </div>
    <a href="{{ route('admin.hadiah.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Hadiah</h3>
    </div>

    <form action="{{ route('admin.hadiah.update', $hadiah->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group">
                        <label class="form-label required">Nama Hadiah</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $hadiah->nama) }}" placeholder="Masukkan nama hadiah" required>
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
                            <input type="number" name="biaya_poin" class="form-control @error('biaya_poin') is-invalid @enderror" value="{{ old('biaya_poin', $hadiah->biaya_poin) }}" placeholder="0" min="0" required style="padding-left: 40px;">
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
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $hadiah->stok) }}" placeholder="0" min="0" required>
                        @error('stok')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Jumlah hadiah yang tersedia untuk ditukar</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="aktif" class="form-control @error('aktif') is-invalid @enderror" required>
                            <option value="1" {{ old('aktif', $hadiah->aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif', $hadiah->aktif) == '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('aktif')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Hadiah aktif dapat ditukar oleh member</small>
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            <div style="margin-top: 24px; padding: 16px; background: var(--bg-body); border-radius: 12px; border-left: 4px solid var(--primary);">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">Ketersediaan</p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: {{ $hadiah->tersedia() ? 'var(--success)' : 'var(--danger)' }};">
                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                            {{ $hadiah->tersedia() ? 'Tersedia' : 'Tidak Tersedia' }}
                        </p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">Total Penukaran</p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: var(--text-main);">
                            <i class="fas fa-exchange-alt"></i>
                            {{ $hadiah->penukaran->count() }} kali
                        </p>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">Dibuat</p>
                        <p style="margin: 4px 0 0; font-weight: 600; color: var(--text-main);">
                            <i class="fas fa-clock"></i>
                            {{ $hadiah->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    Update Hadiah
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