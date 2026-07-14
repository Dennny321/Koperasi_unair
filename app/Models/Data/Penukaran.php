<?php

namespace App\Models\Data;

use App\Models\Master\Hadiah;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Penukaran extends Model
{
    protected $table = '02_penukaran';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_hadiah',
        'poin_digunakan',
        'kode_unik',
        'status',
        'dibuat_pada',
    ];

    protected $casts = [
        'poin_digunakan' => 'integer',
        'dibuat_pada'    => 'datetime',
    ];

    // -------------------------
    // Boot — auto generate kode unik
    // -------------------------

    protected static function booted(): void
    {
        static::creating(function (Penukaran $penukaran) {
            if (empty($penukaran->kode_unik)) {
                $penukaran->kode_unik = strtoupper(
                    'TKR-' . now()->format('Ymd') . '-' . Str::random(8)
                );
            }
        });
    }

    // -------------------------
    // Relasi
    // -------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function hadiah(): BelongsTo
    {
        return $this->belongsTo(Hadiah::class, 'id_hadiah');
    }

    public function riwayatPoin(): HasOne
    {
        return $this->hasOne(RiwayatPoin::class, 'id_penukaran');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiklaim($query)
    {
        return $query->where('status', 'diklaim');
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'dibatalkan');
    }

    // -------------------------
    // Helper
    // -------------------------

    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDiklaim(): bool
    {
        return $this->status === 'diklaim';
    }

    public function isDibatalkan(): bool
    {
        return $this->status === 'dibatalkan';
    }
}