<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class TransaksiSuratJalan extends Model
{
    // Tambahkan ini jika belum ada
    protected $table = '02_transaksi_surat_jalan'; // sesuaikan nama tabel kamu

    protected $fillable = [
        'no_surat',
        'no_transaksi', 
        'id_kasir',
        'tujuan',
        'keterangan',
        'status',
        'total_harga',
    ];

    // Tambahkan ini agar route model binding bekerja
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function kasir()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_kasir');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksiSuratJalan::class, 'id_transaksi');
    }
}