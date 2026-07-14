<?php

namespace App\Models\Data;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPoin extends Model
{
    protected $table = '02_riwayat_poin';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_transaksi',
        'id_penukaran',
        'poin',
        'jenis',
        'keterangan',
        'dibuat_pada',
    ];

    protected $casts = [
        'poin'        => 'integer',
        'dibuat_pada' => 'datetime',
    ];

    // -------------------------
    // Relasi
    // -------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function penukaran(): BelongsTo
    {
        return $this->belongsTo(Penukaran::class, 'id_penukaran');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeMasuk($query)
    {
        return $query->where('jenis', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('jenis', 'keluar');
    }

    public function scopeByUser($query, int $idUser)
    {
        return $query->where('id_user', $idUser);
    }

    // -------------------------
    // Helper
    // -------------------------

    public function isMasuk(): bool
    {
        return $this->jenis === 'masuk';
    }

    public function isKeluar(): bool
    {
        return $this->jenis === 'keluar';
    }

    public function getPoinFormattedAttribute(): string
    {
        $prefix = $this->isMasuk() ? '+' : '-';
        return $prefix . number_format($this->poin, 0, ',', '.');
    }
}