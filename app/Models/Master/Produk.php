<?php

namespace App\Models\Master;

use App\Models\Data\RestockDetail;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasActivityLog;
    protected $table = '01_produk';

    protected $fillable = [
        'id_kategori_produk',
        'kode_produk',
        'nama',
        'stok',
        'stok_minimum',
        'harga',
        'foto',
        'satuan',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi Many to One dengan KategoriProduk
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk');
    }

    /**
     * Accessor untuk menampilkan harga dengan format Rupiah
     */
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 2, ',', '.');
    }

    /**
     * Scope untuk filter produk aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter produk dengan stok minimal
     */
    public function scopeStokMinimal($query)
    {
        return $query->whereRaw('stok <= stok_minimum');
    }

    /**
     * Scope untuk filter produk berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('id_kategori_produk', $kategoriId);
    }

    // Tambahkan relasi ini
    public function restockDetails(): HasMany
    {
        return $this->hasMany(RestockDetail::class, 'id_produk');
    }

    /**
     * Supplier terakhir yang mensuplai produk ini (via restock terbaru)
     */
    public function supplierTerakhir()
    {
        return $this->restockDetails()
            ->with('restock.supplier')
            ->latest()
            ->first()
            ?->restock
            ?->supplier;
    }

    /**
     * Semua supplier unik yang pernah mensuplai produk ini
     */
    public function suppliers()
    {
        return RestockDetail::where('id_produk', $this->id)
            ->with('restock.supplier')
            ->get()
            ->pluck('restock.supplier')
            ->filter()
            ->unique('id')
            ->values();
    }
}
