@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('breadcrumb', 'Master / Produk / Tambah')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah Produk Baru</h2>
        <p style="color: var(--text-secondary);">Lengkapi form di bawah untuk menambah produk</p>
    </div>
    <a href="{{ route('admin.produk.index') }}" class="btn btn-warning">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Produk</h3>
    </div>

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="padding: 24px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group">
                        <label class="form-label required">Kategori Produk</label>
                        <select name="id_kategori_produk" class="form-control @error('id_kategori_produk') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('id_kategori_produk') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori_produk')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Kode Produk</label>
                        <input type="text" name="kode_produk" id="kode_produk" class="form-control @error('kode_produk') is-invalid @enderror" value="{{ old('kode_produk') }}" placeholder="Ketik kode atau scan dengan alat barcode scanner" required>
                        <small class="form-text text-muted">
                            <i class="fas fa-barcode"></i> Gunakan alat scanner barcode untuk input otomatis
                        </small>
                        @error('kode_produk')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nama Produk</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama produk" required>
                        @error('nama')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Harga</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" placeholder="0" step="0.01" min="0" required>
                        @error('harga')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="form-group">
                        <label class="form-label">Stok</label>
                       <input type="number" name="stok" class="form-control" value="0" placeholder="0" min="0" readonly style="background-color: var(--bg-body); cursor: not-allowed; opacity: 0.7;">
<small class="form-text text-muted"><i class="fas fa-lock"></i> Stok dikelola otomatis melalui transaksi restock</small>
                        @error('stok')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Stok Minimum</label>
                        <input type="number" name="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror" value="{{ old('stok_minimum', 0) }}" placeholder="0" min="0" required>
                        @error('stok_minimum')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Satuan</label>
                        <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan') }}" placeholder="Contoh: Pcs, Kg, Liter" required>
                        @error('satuan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Foto Upload (Full Width) -->
            <div class="form-group">
                <label class="form-label">Foto Produk</label>
                <div class="form-file">
                    <input type="file" name="foto" id="foto" accept="image/*" class="@error('foto') is-invalid @enderror" onchange="previewImage(event)">
                    <label for="foto" class="form-file-label">
                        <div id="preview-container">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p style="margin: 8px 0 4px; font-weight: 600; color: var(--text-main);">Klik untuk upload foto</p>
                            <p style="font-size: 12px; color: var(--text-secondary);">Format: JPG, PNG (Max. 2MB)</p>
                        </div>
                    </label>
                </div>
                @error('foto')
                    <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                @enderror
                <div id="image-preview" style="margin-top: 16px; display: none;">
                    <img id="preview-img" src="" alt="Preview" style="max-width: 300px; border-radius: 10px; border: 2px solid var(--border-color);">
                </div>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i>
                    Simpan Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-warning btn-lg">
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
    // Preview Image Function
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
                document.getElementById('preview-container').innerHTML = `
                    <i class="fas fa-check-circle" style="color: var(--success); font-size: 24px;"></i>
                    <p style="margin: 8px 0 4px; font-weight: 600; color: var(--success);">Foto berhasil dipilih!</p>
                    <p style="font-size: 12px; color: var(--text-secondary);">${file.name}</p>
                `;
            }
            reader.readAsDataURL(file);
        }
    }

    // ===========================
    // KEYBOARD BARCODE SCANNER
    // Mendukung alat scanner USB/Bluetooth yang mensimulasikan keyboard
    // ===========================
    (function() {
        let barcodeBuffer = '';
        let barcodeTimer  = null;
        const kodeProdukInput = document.getElementById('kode_produk');

        document.addEventListener('keydown', function(e) {
            // Hanya aktif jika fokus di input kode_produk atau tidak di input lain
            const activeElement = document.activeElement;
            const isInOtherInput = (activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA' || activeElement.tagName === 'SELECT')
                                    && activeElement.id !== 'kode_produk';

            if (isInOtherInput) return;

            if (e.key === 'Enter') {
                // Enter = akhir dari scan barcode
                if (barcodeBuffer.length >= 3) {
                    e.preventDefault();
                    kodeProdukInput.value = barcodeBuffer.trim();
                    kodeProdukInput.focus();

                    // Visual feedback
                    kodeProdukInput.style.borderColor = '#10b981';
                    kodeProdukInput.style.backgroundColor = '#d1fae5';
                    setTimeout(() => {
                        kodeProdukInput.style.borderColor = '';
                        kodeProdukInput.style.backgroundColor = '';
                    }, 1000);

                    showToast('✓ Barcode terdeteksi: ' + barcodeBuffer.trim(), 'success');
                }
                barcodeBuffer = '';
                if (barcodeTimer) clearTimeout(barcodeTimer);
                return;
            }

            // Karakter printable (hanya jika tidak fokus di input lain)
            if (e.key.length === 1 && activeElement.id !== 'kode_produk') {
                barcodeBuffer += e.key;
                // Reset buffer jika tidak ada input dalam 200ms (bukan scanner, tapi keyboard biasa)
                if (barcodeTimer) clearTimeout(barcodeTimer);
                barcodeTimer = setTimeout(() => { barcodeBuffer = ''; }, 200);
            }
        });

        // Juga tangkap input langsung di field kode_produk
        kodeProdukInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                // Pindah fokus ke field berikutnya
                const nextField = document.querySelector('input[name="nama"]');
                if (nextField) nextField.focus();
            }
        });
    })();

    // Toast Notification
    function showToast(msg, type = 'success') {
        const existing = document.getElementById('produkToast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'produkToast';
        toast.style.cssText = `
            position: fixed; bottom: 24px; right: 24px; z-index: 99999;
            background: ${type === 'success' ? '#065f46' : '#991b1b'};
            color: white; padding: 12px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600; box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            animation: toastIn 0.3s ease; max-width: 300px;
        `;
        toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle" style="margin-right:8px;"></i>${msg}`;

        const style = document.createElement('style');
        style.textContent = '@keyframes toastIn { from { opacity:0; transform: translateY(20px); } to { opacity:1; transform: translateY(0); } }';
        document.head.appendChild(style);

        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }
</script>
@endpush