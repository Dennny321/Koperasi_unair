@extends('layouts.app')

@section('title', 'Edit Kategori Produk')
@section('breadcrumb', 'Master / Kategori Produk / Edit')
@section('page-title', 'Edit Kategori Produk')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Edit Kategori Produk</h2>
        <p style="color: var(--text-secondary);">Perbarui data kategori produk</p>
    </div>
    <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Kategori: {{ $kategoriProduk->nama }}</h3>
    </div>

    <form action="{{ route('admin.kategori-produk.update', $kategoriProduk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group">
                        <label class="form-label required">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $kategoriProduk->nama) }}" placeholder="Contoh: Makanan, Minuman, ATK" required>
                        @error('nama')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Deskripsi singkat kategori ini...">{{ old('keterangan', $kategoriProduk->keterangan) }}</textarea>
                        @error('keterangan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Info produk terkait -->
                    <div style="background: var(--bg-body); border-radius: 10px; padding: 16px; border-left: 4px solid var(--info);">
                        <p style="margin: 0 0 4px; font-weight: 600; font-size: 13px; color: var(--text-secondary);">INFO</p>
                        <p style="margin: 0; font-size: 14px;">Kategori ini memiliki
                            <strong style="color: var(--primary);">{{ $kategoriProduk->produk->count() }} produk</strong> terkait.
                        </p>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="form-group">
                        <label class="form-label">Ikon (FontAwesome Class)</label>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <input type="text" name="ikon" id="ikon-input" class="form-control @error('ikon') is-invalid @enderror"
                                value="{{ old('ikon', $kategoriProduk->ikon) }}" placeholder="Contoh: fas fa-box">
                            <div id="ikon-preview" style="min-width: 44px; height: 44px; background: var(--bg-body); border: 1px solid var(--border-color); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i id="ikon-preview-icon" class="{{ old('ikon', $kategoriProduk->ikon ?? 'fas fa-tag') }}" style="font-size: 20px; color: var(--primary);"></i>
                            </div>
                        </div>
                        @error('ikon')
                            <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                        <small style="color: var(--text-secondary); margin-top: 6px; display: block;">
                            Gunakan class dari <a href="https://fontawesome.com/icons" target="_blank" style="color: var(--primary);">Font Awesome</a>.
                            Contoh: <code>fas fa-box</code>, <code>fas fa-utensils</code>, <code>fas fa-tshirt</code>
                        </small>
                    </div>

                    <!-- Ikon Cepat -->
                    <div class="form-group">
                        <label class="form-label">Pilih Ikon Cepat</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach([
                                'fas fa-box' => 'Kotak',
                                'fas fa-utensils' => 'Makanan',
                                'fas fa-coffee' => 'Minuman',
                                'fas fa-tshirt' => 'Pakaian',
                                'fas fa-pen' => 'ATK',
                                'fas fa-laptop' => 'Elektronik',
                                'fas fa-first-aid' => 'Kesehatan',
                                'fas fa-book' => 'Buku',
                                'fas fa-blender' => 'Peralatan',
                                'fas fa-tag' => 'Umum',
                            ] as $class => $label)
                            <button type="button" class="btn btn-sm icon-pick-btn"
                                style="background: {{ old('ikon', $kategoriProduk->ikon) === $class ? 'rgba(var(--primary-rgb), 0.08)' : 'var(--bg-body)' }}; border: 1px solid {{ old('ikon', $kategoriProduk->ikon) === $class ? 'var(--primary)' : 'var(--border-color)' }}; border-radius: 8px; padding: 6px 10px; display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer;"
                                onclick="setIkon('{{ $class }}')" title="{{ $label }}">
                                <i class="{{ $class }}" style="font-size: 16px; color: var(--primary);"></i>
                                <span style="font-size: 10px; color: var(--text-secondary);">{{ $label }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.kategori-produk.index') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function setIkon(iconClass) {
        document.getElementById('ikon-input').value = iconClass;
        document.getElementById('ikon-preview-icon').className = iconClass;

        document.querySelectorAll('.icon-pick-btn').forEach(btn => {
            btn.style.borderColor = 'var(--border-color)';
            btn.style.background = 'var(--bg-body)';
        });
        event.currentTarget.style.borderColor = 'var(--primary)';
        event.currentTarget.style.background = 'rgba(var(--primary-rgb), 0.08)';
    }

    document.getElementById('ikon-input').addEventListener('input', function () {
        document.getElementById('ikon-preview-icon').className = this.value || 'fas fa-tag';
    });
</script>
@endpush