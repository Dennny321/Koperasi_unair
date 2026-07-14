<?php

namespace App\Models;

use App\Models\Data\Penukaran;
use App\Models\Data\RiwayatPoin;
use App\Models\Data\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'no_telepon',
        'password',
        'role',
        'saldo_poin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'saldo_poin'        => 'integer',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    // -------------------------
    // Relasi
    // -------------------------

    public function transaksiSebagaiKasir(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_kasir');
    }

    public function transaksiSebagaiMember(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_member');
    }

    public function riwayatPoin(): HasMany
    {
        return $this->hasMany(RiwayatPoin::class, 'id_user');
    }

    public function penukaran(): HasMany
    {
        return $this->hasMany(Penukaran::class, 'id_user');
    }

    // -------------------------
    // Scope
    // -------------------------

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeKasir($query)
    {
        return $query->where('role', 'kasir');
    }

    public function scopeMember($query)
    {
        return $query->where('role', 'member');
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    // -------------------------
    // Helper
    // -------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isPegawai(): bool
    {
        return in_array($this->role, ['admin', 'kasir']);
    }
}