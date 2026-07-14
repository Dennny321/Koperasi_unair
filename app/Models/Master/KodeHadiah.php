<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class KodeHadiah extends Model
{
    protected $table = '01_kode_hadiah';

    protected $fillable = [
        'id_hadiah',
        'id_member',
        'kode_hadiah',
        'jumlah_poin',
        'status',
    ];

    protected $casts = [
        'jumlah_poin' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // -------------------------
    // Boot — auto generate kode_hadiah
    // -------------------------

    protected static function booted(): void
    {
        static::creating(function (KodeHadiah $kode) {
            if (empty($kode->kode_hadiah)) {
                $kode->kode_hadiah = strtoupper(
                    'KH-' . now()->format('Ymd') . '-' . Str::random(8)
                );
            }
        });
    }

    // -------------------------
    // Relasi
    // -------------------------

    public function hadiah(): BelongsTo
    {
        return $this->belongsTo(Hadiah::class, 'id_hadiah');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_member');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeDiredeem($query)
    {
        return $query->where('status', 'diredeem');
    }

    // -------------------------
    // Helper
    // -------------------------

    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }

    public function isDiredeem(): bool
    {
        return $this->status === 'diredeem';
    }
}
