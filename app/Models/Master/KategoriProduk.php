<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriProduk extends Model
{
    protected $table = '01_kategori_produk';

    protected $fillable = [
        'nama',
        'keterangan',
        'ikon',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi One to Many dengan Produk
     */
    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_kategori_produk');
    }
}