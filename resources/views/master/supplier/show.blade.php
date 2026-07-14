@extends('layouts.app')


@section('title', 'Detail Supplier')
@section('breadcrumb', 'Master / Supplier / Detail')
@section('page-title', 'Detail Supplier')


@section('content')
<div class="content-header">
   <div>
       <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Supplier</h2>
       <p style="color: var(--text-secondary);">Informasi lengkap supplier</p>
   </div>
   <div style="display: flex; gap: 12px;">
       <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-warning">
           <i class="fas fa-edit"></i>
           Edit Supplier
       </a>
       <a href="{{ route('admin.supplier.index') }}" class="btn btn-primary">
           <i class="fas fa-arrow-left"></i>
           Kembali
       </a>
   </div>
</div>


<!-- Card Informasi Supplier -->
<div class="card">
   <div class="card-header">
       <h3 class="card-title">Informasi Supplier</h3>
       <div style="display: flex; gap: 8px;">
           <button class="btn btn-success btn-sm" onclick="window.print()">
               <i class="fas fa-print"></i> Print
           </button>
           <button class="btn btn-info btn-sm">
               <i class="fas fa-share-alt"></i> Share
           </button>
       </div>
   </div>


   <div style="padding: 24px;">
       <!-- Detail Table -->
       <table style="width: 100%; border-collapse: collapse;">
           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; width: 200px; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-barcode" style="margin-right: 8px; color: var(--primary);"></i>
                   Kode Supplier
               </td>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                   {{ $supplier->kode_supplier }}
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-building" style="margin-right: 8px; color: var(--primary);"></i>
                   Nama Supplier
               </td>
               <td style="padding: 16px 0; font-weight: 700; color: var(--primary); font-size: 18px;">
                   {{ $supplier->nama }}
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-phone" style="margin-right: 8px; color: var(--primary);"></i>
                   Telepon
               </td>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                   @if($supplier->telepon)
                       <a href="tel:{{ $supplier->telepon }}" style="color: var(--success); text-decoration: none;">
                           <i class="fas fa-phone-alt"></i> {{ $supplier->telepon }}
                       </a>
                   @else
                       <span style="color: var(--text-secondary);">Tidak ada nomor telepon</span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-envelope" style="margin-right: 8px; color: var(--primary);"></i>
                   Email
               </td>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                   @if($supplier->email)
                       <a href="mailto:{{ $supplier->email }}" style="color: var(--info); text-decoration: none;">
                           <i class="fas fa-envelope"></i> {{ $supplier->email }}
                       </a>
                   @else
                       <span style="color: var(--text-secondary);">Tidak ada email</span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary); vertical-align: top;">
                   <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: var(--primary);"></i>
                   Alamat
               </td>
               <td style="padding: 16px 0; color: var(--text-main); line-height: 1.6;">
                   @if($supplier->alamat)
                       {{ $supplier->alamat }}
                   @else
                       <span style="color: var(--text-secondary);">Tidak ada alamat</span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-toggle-on" style="margin-right: 8px; color: var(--primary);"></i>
                   Status
               </td>
               <td style="padding: 16px 0;">
                   @if($supplier->status == 'aktif')
                       <span class="badge badge-success" style="padding: 8px 16px; font-size: 13px;">
                           <i class="fas fa-check-circle"></i> Aktif
                       </span>
                   @else
                       <span class="badge badge-danger" style="padding: 8px 16px; font-size: 13px;">
                           <i class="fas fa-times-circle"></i> Non-Aktif
                       </span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-calendar-plus" style="margin-right: 8px; color: var(--primary);"></i>
                   Dibuat Pada
               </td>
               <td style="padding: 16px 0; color: var(--text-main);">
                   {{ $supplier->created_at->format('d F Y, H:i') }} WIB
                   <span style="font-size: 12px; color: var(--text-secondary);">
                       ({{ $supplier->created_at->diffForHumans() }})
                   </span>
               </td>
           </tr>


           <tr>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-calendar-check" style="margin-right: 8px; color: var(--primary);"></i>
                   Terakhir Diupdate
               </td>
               <td style="padding: 16px 0; color: var(--text-main);">
                   {{ $supplier->updated_at->format('d F Y, H:i') }} WIB
                   <span style="font-size: 12px; color: var(--text-secondary);">
                       ({{ $supplier->updated_at->diffForHumans() }})
                   </span>
               </td>
           </tr>
       </table>


       <!-- Action Buttons -->
       <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
           <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-warning btn-lg">
               <i class="fas fa-edit"></i>
               Edit Supplier
           </a>


           <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini? Tindakan ini tidak dapat dibatalkan!')">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger btn-lg">
                   <i class="fas fa-trash"></i>
                   Hapus Supplier
               </button>
           </form>
       </div>
   </div>
</div>


<!-- Card Riwayat Restock -->
<div class="card" style="margin-top: 24px;">
   <div class="card-header">
       <h3 class="card-title">Riwayat Restock (10 Terakhir)</h3>
       <a href="{{ route('admin.restock.index', ['supplier' => $supplier->id]) }}" class="btn btn-primary btn-sm">
           <i class="fas fa-list"></i> Lihat Semua
       </a>
   </div>


   <div class="table-responsive">
       <table class="table">
           <thead>
               <tr>
                   <th>Kode Restock</th>
                   <th>Tanggal</th>
                   <th>Total Biaya</th>
                   <th>Status</th>
                   <th>Dibuat Oleh</th>
                   <th style="text-align: center;">Aksi</th>
               </tr>
           </thead>
           <tbody>
               @forelse($supplier->restocks as $restock)
               <tr>
                   <td><strong>{{ $restock->kode_restock }}</strong></td>
                   <td>{{ $restock->tanggal_restock_formatted }}</td>
                   <td><strong style="color: var(--success);">{{ $restock->total_biaya_formatted }}</strong></td>
                   <td>
                       @if($restock->status == 'selesai')
                           <span class="badge badge-success">Selesai</span>
                       @elseif($restock->status == 'draft')
                           <span class="badge badge-warning">Draft</span>
                       @else
                           <span class="badge badge-danger">Dibatalkan</span>
                       @endif
                   </td>
                   <td>{{ $restock->user->name }}</td>
                   <td style="text-align: center;">
                       <a href="{{ route('admin.restock.show', $restock->id) }}" class="btn btn-info btn-sm">
                           <i class="fas fa-eye"></i>
                       </a>
                   </td>
               </tr>
               @empty
               <tr>
                   <td colspan="6" class="text-center" style="padding: 40px;">
                       <i class="fas fa-inbox" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 16px;"></i>
                       <p style="color: var(--text-secondary); font-size: 16px;">Belum ada riwayat restock</p>
                   </td>
               </tr>
               @endforelse
           </tbody>
       </table>
   </div>
</div>


<!-- Print Styles -->
<style>
   @media print {
       .sidebar,
       .top-navbar,
       .content-header,
       .btn,
       .card-header > div {
           display: none !important;
       }


       .main-wrapper {
           margin-left: 0 !important;
       }


       .content-body {
           padding: 0 !important;
       }


       .card {
           box-shadow: none !important;
           page-break-inside: avoid;
       }


       body {
           background: white !important;
       }
   }
</style>
@endsection




