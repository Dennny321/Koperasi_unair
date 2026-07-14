@extends('layouts.app')


@section('title', 'Edit Restock')
@section('breadcrumb', 'Master / Restock / Edit')
@section('page-title', 'Edit Restock')


@section('content')
<div class="content-header">
   <div>
       <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Edit Restock</h2>
       <p style="color: var(--text-secondary);">Update informasi restock yang sudah ada</p>
   </div>
   <a href="{{ route('admin.restock.index') }}" class="btn btn-warning">
       <i class="fas fa-arrow-left"></i>
       Kembali
   </a>
</div>


<form action="{{ route('admin.restock.update', $restock->id) }}" method="POST" id="restockForm">
   @csrf
   @method('PUT')


   <!-- Card Informasi Restock -->
   <div class="card">
       <div class="card-header">
           <h3 class="card-title">Informasi Restock</h3>
       </div>


       <div style="padding: 24px;">
           <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
               <div class="form-group">
                   <label class="form-label required">Kode Restock</label>
                   <input type="text" name="kode_restock" class="form-control @error('kode_restock') is-invalid @enderror" value="{{ old('kode_restock', $restock->kode_restock) }}" readonly required>
                   @error('kode_restock')
                       <span class="invalid-feedback">{{ $message }}</span>
                   @enderror
               </div>


               <div class="form-group">
                   <label class="form-label required">Tanggal Restock</label>
                   <input type="date" name="tanggal_restock" class="form-control @error('tanggal_restock') is-invalid @enderror" value="{{ old('tanggal_restock', $restock->tanggal_restock) }}" required>
                   @error('tanggal_restock')
                       <span class="invalid-feedback">{{ $message }}</span>
                   @enderror
               </div>


               <div class="form-group">
                   <label class="form-label">Supplier</label>
                   <select name="id_supplier" class="form-control @error('id_supplier') is-invalid @enderror">
                       <option value="">Pilih Supplier (Opsional)</option>
                       @foreach($suppliers as $supplier)
                           <option value="{{ $supplier->id }}" {{ old('id_supplier', $restock->id_supplier) == $supplier->id ? 'selected' : '' }}>
                               {{ $supplier->nama }}
                           </option>
                       @endforeach
                   </select>
                   @error('id_supplier')
                       <span class="invalid-feedback">{{ $message }}</span>
                   @enderror
               </div>
           </div>


           <div class="form-group">
               <label class="form-label">Keterangan</label>
               <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="2" placeholder="Catatan tambahan...">{{ old('keterangan', $restock->keterangan) }}</textarea>
               @error('keterangan')
                   <span class="invalid-feedback">{{ $message }}</span>
               @enderror
           </div>


           <div class="form-group">
               <label class="form-label required">Status</label>
               <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                   <option value="draft" {{ old('status', $restock->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                   <option value="selesai" {{ old('status', $restock->status) == 'selesai' ? 'selected' : '' }}>Selesai (Langsung Update Stok)</option>
               </select>
               @error('status')
                   <span class="invalid-feedback">{{ $message }}</span>
               @enderror
               <small style="color: var(--text-secondary);">Jika status "Selesai", stok produk akan langsung bertambah.</small>
           </div>
       </div>
   </div>


   <!-- Card Daftar Produk -->
   <div class="card" style="margin-top: 24px;">
       <div class="card-header">
           <h3 class="card-title">Daftar Produk</h3>
           <button type="button" class="btn btn-primary btn-sm" onclick="tambahProduk()">
               <i class="fas fa-plus"></i> Tambah Produk
           </button>
       </div>


       <div style="padding: 24px;">
           <div id="produkContainer">
               <!-- Produk items akan ditambahkan di sini -->
           </div>


           @error('produk')
               <div class="alert alert-danger" style="margin-top: 16px;">
                   {{ $message }}
               </div>
           @enderror


           <!-- Total Biaya -->
           <div style="margin-top: 24px; padding: 20px; background: var(--bg-body); border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
               <h3 style="margin: 0; color: var(--text-main);">Total Biaya:</h3>
               <h2 style="margin: 0; color: var(--success); font-size: 28px; font-weight: 800;" id="totalBiaya">Rp 0</h2>
           </div>
       </div>
   </div>


   <!-- Buttons -->
   <div style="display: flex; gap: 12px; margin-top: 24px;">
       <button type="submit" class="btn btn-primary btn-lg">
           <i class="fas fa-save"></i>
           Update Restock
       </button>
       <a href="{{ route('admin.restock.index') }}" class="btn btn-warning btn-lg">
           <i class="fas fa-times"></i>
           Batal
       </a>
   </div>
</form>


<!-- Template Produk Item -->
<template id="produkItemTemplate">
   <div class="produk-item" style="border: 2px solid var(--border-color); border-radius: 10px; padding: 20px; margin-bottom: 16px; position: relative;">
       <button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(this)" style="position: absolute; top: 16px; right: 16px;">
           <i class="fas fa-trash"></i>
       </button>


       <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 2fr; gap: 16px; align-items: start;">
           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label required">Produk</label>
               <select name="produk[INDEX][id_produk]" class="form-control produk-select" required onchange="updateProdukInfo(this)">
                   <option value="">Pilih Produk</option>
                   @foreach($produks as $produk)
                       <option value="{{ $produk->id }}"
                               data-kode="{{ $produk->kode_produk }}"
                               data-stok="{{ $produk->stok }}"
                               data-harga="{{ $produk->harga }}"
                               data-satuan="{{ $produk->satuan }}">
                           {{ $produk->nama }} ({{ $produk->kategori->nama ?? 'No Category' }})
                       </option>
                   @endforeach
               </select>
           </div>


           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label required">Jumlah</label>
               <input type="number" name="produk[INDEX][jumlah]" class="form-control jumlah-input" placeholder="0" min="1" required onchange="hitungSubtotal(this)">
           </div>


           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label required">Harga Beli</label>
               <input type="number" name="produk[INDEX][harga_beli]" class="form-control harga-input" placeholder="0" step="0.01" min="0" required onchange="hitungSubtotal(this)">
           </div>


           <div class="form-group" style="margin-bottom: 0;">
               <label class="form-label">Catatan</label>
               <input type="text" name="produk[INDEX][catatan]" class="form-control" placeholder="Catatan produk...">
           </div>
       </div>


       <div class="produk-info" style="margin-top: 12px; padding: 12px; background: var(--bg-body); border-radius: 8px; display: none;">
           <div style="display: flex; justify-content: space-between; font-size: 13px;">
               <div>
                   <strong>Kode:</strong> <span class="info-kode">-</span> |
                   <strong>Stok Saat Ini:</strong> <span class="info-stok">-</span> <span class="info-satuan"></span>
               </div>
               <div>
                   <strong>Subtotal:</strong> <span class="info-subtotal" style="color: var(--success); font-weight: 700; font-size: 15px;">Rp 0</span>
               </div>
           </div>
       </div>
   </div>
</template>
@endsection


@push('scripts')
<script>
   let produkIndex = 0;


   // Data produk existing dari backend
   const existingDetails = @json($restock->details);


   // Tambah produk baru
   function tambahProduk(detail = null) {
       const template = document.getElementById('produkItemTemplate');
       const clone = template.content.cloneNode(true);


       // Replace INDEX dengan index yang sebenarnya
       let html = clone.querySelector('.produk-item').outerHTML.replace(/INDEX/g, produkIndex);


       document.getElementById('produkContainer').insertAdjacentHTML('beforeend', html);


       // Jika ada detail (untuk edit), set nilainya
       if (detail) {
           const item = document.querySelectorAll('.produk-item')[document.querySelectorAll('.produk-item').length - 1];


           // Set produk
           const selectProduk = item.querySelector('.produk-select');
           selectProduk.value = detail.id_produk;
           updateProdukInfo(selectProduk);


           // Set jumlah
           item.querySelector('.jumlah-input').value = detail.jumlah;


           // Set harga beli
           item.querySelector('.harga-input').value = detail.harga_beli;


           // Set catatan
           item.querySelector('input[name*="catatan"]').value = detail.catatan || '';


           // Hitung subtotal
           hitungSubtotal(item.querySelector('.jumlah-input'));
       }


       produkIndex++;
   }


   // Hapus produk
   function hapusProduk(btn) {
       btn.closest('.produk-item').remove();
       hitungTotalBiaya();
   }


   // Update info produk
   function updateProdukInfo(select) {
       const item = select.closest('.produk-item');
       const option = select.options[select.selectedIndex];


       if (select.value) {
           item.querySelector('.info-kode').textContent = option.dataset.kode;
           item.querySelector('.info-stok').textContent = option.dataset.stok;
           item.querySelector('.info-satuan').textContent = option.dataset.satuan;


           // Set harga beli default jika belum ada nilai
           const hargaInput = item.querySelector('.harga-input');
           if (!hargaInput.value || hargaInput.value == 0) {
               hargaInput.value = option.dataset.harga;
           }


           item.querySelector('.produk-info').style.display = 'block';


           hitungSubtotal(select);
       } else {
           item.querySelector('.produk-info').style.display = 'none';
       }
   }


   // Hitung subtotal per item
   function hitungSubtotal(element) {
       const item = element.closest('.produk-item');
       const jumlah = parseFloat(item.querySelector('.jumlah-input').value) || 0;
       const harga = parseFloat(item.querySelector('.harga-input').value) || 0;
       const subtotal = jumlah * harga;


       item.querySelector('.info-subtotal').textContent = formatRupiah(subtotal);


       hitungTotalBiaya();
   }


   // Hitung total biaya keseluruhan
   function hitungTotalBiaya() {
       let total = 0;
       document.querySelectorAll('.produk-item').forEach(item => {
           const jumlah = parseFloat(item.querySelector('.jumlah-input').value) || 0;
           const harga = parseFloat(item.querySelector('.harga-input').value) || 0;
           total += jumlah * harga;
       });


       document.getElementById('totalBiaya').textContent = formatRupiah(total);
   }


   // Format rupiah
   function formatRupiah(angka) {
       return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
   }


   // Validasi form sebelum submit
   document.getElementById('restockForm').addEventListener('submit', function(e) {
       const produkItems = document.querySelectorAll('.produk-item');


       if (produkItems.length === 0) {
           e.preventDefault();
           alert('Tambahkan minimal 1 produk!');
           return false;
       }
   });


   // Load existing details saat halaman load
   window.addEventListener('load', function() {
       if (existingDetails.length > 0) {
           existingDetails.forEach(detail => {
               tambahProduk(detail);
           });
       } else {
           // Jika tidak ada detail, tambah 1 produk kosong
           tambahProduk();
       }
   });
</script>
@endpush




