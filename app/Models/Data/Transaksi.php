<?php

namespace App\Models\Data;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaksi extends Model
{
    protected $table = '02_transaksi';

    public $timestamps = false;

    protected $fillable = [
        'no_transaksi',
        'no_nota',          // ← Nomor nota / surat jalan
        'id_kasir',
        'id_member',
        'total_harga',
        'total_bayar',
        'kembalian',
        'metode_bayar',
        'status',
        'dibuat_pada',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'kembalian'   => 'decimal:2',
        'dibuat_pada' => 'datetime',
    ];

    // -------------------------
    // Relasi
    // -------------------------

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_member');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function riwayatPoin(): HasOne
    {
        return $this->hasOne(RiwayatPoin::class, 'id_transaksi');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeBatal($query)
    {
        return $query->where('status', 'batal');
    }

    public function scopeByMetodeBayar($query, string $metode)
    {
        return $query->where('metode_bayar', $metode);
    }

    public function scopeByMember($query, int $idMember)
    {
        return $query->where('id_member', $idMember);
    }

    public function scopeByKasir($query, int $idKasir)
    {
        return $query->where('id_kasir', $idKasir);
    }

    // -------------------------
    // Helper
    // -------------------------

    public function hasMember(): bool
    {
        return !is_null($this->id_member);
    }

    public function getTotalHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getTotalBayarFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }

    public function getKembalianFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->kembalian, 0, ',', '.');
    }
}
