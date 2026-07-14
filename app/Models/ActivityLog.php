<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'module',
        'description',
        'subject_type',
        'subject_id',
        'subject_label',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'url',
        'method',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ──────────────────────────────────────────────
    // Proteksi: data tidak bisa dihapus sembarangan
    // ──────────────────────────────────────────────

    /**
     * Override delete() — hanya boleh hapus jika data sudah >= 3 bulan
     */
    public function delete(): bool
    {
        if ($this->created_at->gt(now()->subMonths(3))) {
            throw new \RuntimeException(
                'Log aktivitas hanya dapat dihapus setelah berumur 3 bulan.'
            );
        }

        return parent::delete();
    }

    // ──────────────────────────────────────────────
    // Relasi
    // ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    public function scopeOlderThan3Months(Builder $query): Builder
    {
        return $query->where('created_at', '<', now()->subMonths(3));
    }

    public function scopeByAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    public function scopeByModule(Builder $query, string $module): Builder
    {
        return $query->where('module', $module);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    // ──────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'login'  => 'Login',
            'logout' => 'Logout',
            'create' => 'Tambah Data',
            'update' => 'Ubah Data',
            'delete' => 'Hapus Data',
            'view'   => 'Lihat Data',
            default  => ucfirst($this->action),
        };
    }

    public function getActionBadgeAttribute(): string
    {
        return match ($this->action) {
            'login'  => 'badge-info',
            'logout' => 'badge-warning',
            'create' => 'badge-success',
            'update' => 'badge-primary',
            'delete' => 'badge-danger',
            'view'   => 'badge-secondary',
            default  => 'badge-secondary',
        };
    }

    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
            'login'  => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'view'   => 'fa-eye',
            default  => 'fa-circle',
        };
    }

    public function getCanBeDeletedAttribute(): bool
    {
        return $this->created_at->lte(now()->subMonths(3));
    }
}
