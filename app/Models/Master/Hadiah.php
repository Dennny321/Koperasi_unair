<?php

namespace App\Models\Master;

use App\Models\Data\Penukaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hadiah extends Model
{
    protected $table = '01_hadiah';

    protected $fillable = [
        'nama',
        'keterangan',
        'foto',
        'biaya_poin',   // kolom lama: jumlah_poin di skema baru — tetap pakai biaya_poin supaya tidak break
        'stok',
        'aktif',
    ];

    protected $casts = [
        'biaya_poin'  => 'integer',
        'stok'        => 'integer',
        'aktif'       => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // -------------------------
    // Relasi
    // -------------------------

    public function penukaran(): HasMany
    {
        return $this->hasMany(Penukaran::class, 'id_hadiah');
    }

    public function kodeHadiah(): HasMany
    {
        return $this->hasMany(KodeHadiah::class, 'id_hadiah');
    }

    public function kodeHadiahTersedia(): HasMany
    {
        return $this->hasMany(KodeHadiah::class, 'id_hadiah')->where('status', 'tersedia');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeTersedia($query)
    {
        return $query->where('aktif', true)->where('stok', '>', 0);
    }

    // -------------------------
    // Helper
    // -------------------------

    public function isTersedia(): bool
    {
        return $this->aktif && $this->stok > 0;
    }

    public function cukupPoin(int $poinMember): bool
    {
        return $poinMember >= $this->biaya_poin;
    }

    /**
     * Jumlah kode hadiah yang sudah di-generate.
     */
    public function jumlahKodeGenerated(): int
    {
        return $this->kodeHadiah()->count();
    }

    /**
     * Jumlah kode yang masih tersedia (belum diredeem).
     */
    public function jumlahKodeTersedia(): int
    {
        return $this->kodeHadiahTersedia()->count();
    }
}
