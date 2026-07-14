@extends('layouts.app')


@section('title', 'Detail Restock')
@section('breadcrumb', 'Master / Restock / Detail')
@section('page-title', 'Detail Restock')


@section('content')
<div class="content-header">
   <div>
       <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Restock</h2>
       <p style="color: var(--text-secondary);">Informasi lengkap restock</p>
   </div>
   <div style="display: flex; gap: 12px;">
       @if($restock->status == 'draft')
           <a href="{{ route('admin.restock.edit', $restock->id) }}" class="btn btn-warning">
               <i class="fas fa-edit"></i>
               Edit Restock
           </a>
       @endif
       <a href="{{ route('admin.restock.index') }}" class="btn btn-primary">
           <i class="fas fa-arrow-left"></i>
           Kembali
       </a>
   </div>
</div>


<!-- Card Informasi Restock -->
<div class="card">
   <div class="card-header">
       <h3 class="card-title">Informasi Restock</h3>
       <div style="display: flex; gap: 8px;">
           <button class="btn btn-success btn-sm" onclick="window.print()">
               <i class="fas fa-print"></i> Print
           </button>
           @if($restock->status == 'draft')
               <form action="{{ route('admin.restock.approve', $restock->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Approve restock ini? Stok produk akan bertambah.')">
                   @csrf
                   <button type="submit" class="btn btn-success btn-sm">
                       <i class="fas fa-check"></i> Approve
                   </button>
               </form>
               <form action="{{ route('admin.restock.cancel', $restock->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Batalkan restock ini?')">
                   @csrf
                   <button type="submit" class="btn btn-danger btn-sm">
                       <i class="fas fa-ban"></i> Batalkan
                   </button>
               </form>
           @endif
       </div>
   </div>


   <div style="padding: 24px;">
       <!-- Detail Table -->
       <table style="width: 100%; border-collapse: collapse;">
           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; width: 200px; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-barcode" style="margin-right: 8px; color: var(--primary);"></i>
                   Kode Restock
               </td>
               <td style="padding: 16px 0; font-weight: 700; color: var(--primary); font-size: 18px;">
                   {{ $restock->kode_restock }}
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-calendar" style="margin-right: 8px; color: var(--primary);"></i>
                   Tanggal Restock
               </td>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                   {{ $restock->tanggal_restock_formatted }}
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-building" style="margin-right: 8px; color: var(--primary);"></i>
                   Supplier
               </td>
               <td style="padding: 16px 0;">
                   @if($restock->supplier)
                       <span class="badge badge-info" style="padding: 8px 16px; font-size: 13px;">
                           {{ $restock->supplier->nama }}
                       </span>
                   @else
                       <span class="badge badge-secondary">Tanpa Supplier</span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: var(--primary);"></i>
                   Total Biaya
               </td>
               <td style="padding: 16px 0;">
                   <span style="font-size: 28px; font-weight: 800; color: var(--success);">
                       {{ $restock->total_biaya_formatted }}
                   </span>
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-toggle-on" style="margin-right: 8px; color: var(--primary);"></i>
                   Status
               </td>
               <td style="padding: 16px 0;">
                   @if($restock->status == 'selesai')
                       <span class="badge badge-success" style="padding: 10px 20px; font-size: 14px;">
                           <i class="fas fa-check-circle"></i> Selesai
                       </span>
                   @elseif($restock->status == 'draft')
                       <span class="badge badge-warning" style="padding: 10px 20px; font-size: 14px;">
                           <i class="fas fa-clock"></i> Draft
                       </span>
                   @else
                       <span class="badge badge-danger" style="padding: 10px 20px; font-size: 14px;">
                           <i class="fas fa-ban"></i> Dibatalkan
                       </span>
                   @endif
               </td>
           </tr>


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-user" style="margin-right: 8px; color: var(--primary);"></i>
                   Dibuat Oleh
               </td>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-main);">
                   {{ $restock->user->name }}
               </td>
           </tr>


           @if($restock->keterangan)
           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary); vertical-align: top;">
                   <i class="fas fa-sticky-note" style="margin-right: 8px; color: var(--primary);"></i>
                   Keterangan
               </td>
               <td style="padding: 16px 0; color: var(--text-main); line-height: 1.6;">
                   {{ $restock->keterangan }}
               </td>
           </tr>
           @endif


           <tr style="border-bottom: 1px solid var(--border-color);">
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-calendar-plus" style="margin-right: 8px; color: var(--primary);"></i>
                   Dibuat Pada
               </td>
               <td style="padding: 16px 0; color: var(--text-main);">
                   {{ $restock->created_at->format('d F Y, H:i') }} WIB
                   <span style="font-size: 12px; color: var(--text-secondary);">
                       ({{ $restock->created_at->diffForHumans() }})
                   </span>
               </td>
           </tr>


           <tr>
               <td style="padding: 16px 0; font-weight: 600; color: var(--text-secondary);">
                   <i class="fas fa-calendar-check" style="margin-right: 8px; color: var(--primary);"></i>
                   Terakhir Diupdate
               </td>
               <td style="padding: 16px 0; color: var(--text-main);">
                   {{ $restock->updated_at->format('d F Y, H:i') }} WIB
                   <span style="font-size: 12px; color: var(--text-secondary);">
                       ({{ $restock->updated_at->diffForHumans() }})
                   </span>
               </td>
           </tr>
       </table>


       <!-- Action Buttons -->
       @if($restock->status == 'draft')
       <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 2px solid var(--bg-body);">
           <a href="{{ route('admin.restock.edit', $restock->id) }}" class="btn btn-warning btn-lg">
               <i class="fas fa-edit"></i>
               Edit Restock
           </a>


           <form action="{{ route('admin.restock.destroy', $restock->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus restock ini? Tindakan ini tidak dapat dibatalkan!')">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger btn-lg">
                   <i class="fas fa-trash"></i>
                   Hapus Restock
               </button>
           </form>
       </div>
       @endif
   </div>
</div>


<!-- Card Detail Produk -->
<div class="card" style="margin-top: 24px;">
   <div class="card-header">
       <h3 class="card-title">Detail Produk ({{ $restock->details->count() }} Item)</h3>
   </div>


   <div class="table-responsive">
       <table class="table">
           <thead>
               <tr>
                   <th style="width: 60px;">No</th>
                   <th>Kode Produk</th>
                   <th>Nama Produk</th>
                   <th>Kategori</th>
                   <th style="text-align: right;">Jumlah</th>
                   <th style="text-align: right;">Harga Beli</th>
                   <th style="text-align: right;">Subtotal</th>
                   <th>Catatan</th>
               </tr>
           </thead>
           <tbody>
               @foreach($restock->details as $index => $detail)
               <tr>
                   <td>{{ $index + 1 }}</td>
                   <td><strong>{{ $detail->produk->kode_produk }}</strong></td>
                   <td>{{ $detail->produk->nama }}</td>
                   <td>
                       @if($detail->produk->kategori)
                           <span class="badge badge-info">{{ $detail->produk->kategori->nama }}</span>
                       @else
                           <span class="badge badge-secondary">No Category</span>
                       @endif
                   </td>
                   <td style="text-align: right;">
                       <strong>{{ $detail->jumlah }}</strong> {{ $detail->produk->satuan }}
                   </td>
                   <td style="text-align: right;">
                       <strong style="color: var(--warning);">{{ $detail->harga_beli_formatted }}</strong>
                   </td>
                   <td style="text-align: right;">
                       <strong style="color: var(--success); font-size: 15px;">{{ $detail->subtotal_formatted }}</strong>
                   </td>
                   <td>
                       @if($detail->catatan)
                           <small style="color: var(--text-secondary);">{{ $detail->catatan }}</small>
                       @else
                           <span style="color: var(--text-secondary);">-</span>
                       @endif
                   </td>
               </tr>
               @endforeach
           </tbody>
           <tfoot style="background: var(--bg-body); font-weight: 700;">
               <tr>
                   <td colspan="6" style="text-align: right; padding: 20px;">
                       <h3 style="margin: 0; color: var(--text-main);">TOTAL BIAYA:</h3>
                   </td>
                   <td colspan="2" style="padding: 20px;">
                       <h2 style="margin: 0; color: var(--success); font-size: 28px;">{{ $restock->total_biaya_formatted }}</h2>
                   </td>
               </tr>
           </tfoot>
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




