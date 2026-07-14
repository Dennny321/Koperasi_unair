@extends('layouts.app')


@section('title', 'Tambah Supplier')
@section('breadcrumb', 'Master / Supplier / Tambah')
@section('page-title', 'Tambah Supplier')


@section('content')
<div class="content-header">
   <div>
       <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Tambah Supplier Baru</h2>
       <p style="color: var(--text-secondary);">Lengkapi formulir di bawah untuk menambah supplier</p>
   </div>
   <a href="{{ route('admin.supplier.index') }}" class="btn btn-warning">
       <i class="fas fa-arrow-left"></i>
       Kembali
   </a>
</div>


<div class="card">
   <div class="card-header">
       <h3 class="card-title">Form Tambah Supplier</h3>
   </div>


   <form action="{{ route('admin.supplier.store') }}" method="POST">
       @csrf


       <div style="padding: 24px;">
           <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
               <!-- Kolom Kiri -->
               <div>
                   <div class="form-group">
                       <label class="form-label required">Kode Supplier</label>
                       <input type="text" name="kode_supplier" class="form-control @error('kode_supplier') is-invalid @enderror" value="{{ old('kode_supplier') }}" placeholder="Contoh: SUP001" required>
                       @error('kode_supplier')
                           <span class="invalid-feedback">{{ $message }}</span>
                       @enderror
                   </div>


                   <div class="form-group">
                       <label class="form-label required">Nama Supplier</label>
                       <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama supplier" required>
                       @error('nama')
                           <span class="invalid-feedback">{{ $message }}</span>
                       @enderror
                   </div>


                   <div class="form-group">
                       <label class="form-label">Telepon</label>
                       <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" placeholder="Contoh: 081234567890">
                       @error('telepon')
                           <span class="invalid-feedback">{{ $message }}</span>
                       @enderror
                   </div>
               </div>


               <!-- Kolom Kanan -->
               <div>
                   <div class="form-group">
                       <label class="form-label">Email</label>
                       <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@supplier.com">
                       @error('email')
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


           <!-- Alamat (Full Width) -->
           <div class="form-group">
               <label class="form-label">Alamat Lengkap</label>
               <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4" placeholder="Masukkan alamat lengkap supplier...">{{ old('alamat') }}</textarea>
               @error('alamat')
                   <span class="invalid-feedback">{{ $message }}</span>
               @enderror
           </div>


           <!-- Buttons -->
           <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
               <button type="submit" class="btn btn-primary btn-lg">
                   <i class="fas fa-save"></i>
                   Simpan Supplier
               </button>
               <a href="{{ route('admin.supplier.index') }}" class="btn btn-warning btn-lg">
                   <i class="fas fa-times"></i>
                   Batal
               </a>
           </div>
       </div>
   </form>
</div>
@endsection




