<?php

namespace App\services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log aktivitas umum
     */
    public static function log(
        string  $action,
        string  $module,
        string  $description = '',
        ?Model  $subject = null,
        ?array  $oldValues = null,
        ?array  $newValues = null,
    ): ActivityLog {
        $user = Auth::user();

        return ActivityLog::create([
            'user_id'       => $user?->id,
            'user_name'     => $user?->name ?? 'System',
            'user_role'     => $user?->role ?? null,
            'action'        => $action,
            'module'        => $module,
            'description'   => $description,
            'subject_type'  => $subject ? get_class($subject) : null,
            'subject_id'    => $subject?->getKey(),
            'subject_label' => $subject ? static::resolveLabel($subject) : null,
            'old_values'    => $oldValues,
            'new_values'    => $newValues,
            'ip_address'    => Request::ip(),
            'user_agent'    => Request::userAgent(),
            'url'           => Request::fullUrl(),
            'method'        => Request::method(),
        ]);
    }

    // ──────────────────────────────────────────────
    // Shortcut methods
    // ──────────────────────────────────────────────

    public static function login(): ActivityLog
    {
        $user = Auth::user();
        return static::log('login', 'Auth', "User '{$user->name}' berhasil login.");
    }

    public static function logout(): ActivityLog
    {
        $user = Auth::user();
        return static::log('logout', 'Auth', "User '{$user->name}' logout.");
    }

    public static function created(Model $model, string $module = ''): ActivityLog
    {
        $module = $module ?: static::resolveModule($model);
        $label  = static::resolveLabel($model);
        return static::log(
            action:    'create',
            module:    $module,
            description: "Menambahkan {$module}: {$label}",
            subject:   $model,
            newValues: $model->getAttributes(),
        );
    }

    public static function updated(Model $model, array $original, string $module = ''): ActivityLog
    {
        $module  = $module ?: static::resolveModule($model);
        $label   = static::resolveLabel($model);
        $changed = array_intersect_key($model->getAttributes(), $original);
        return static::log(
            action:    'update',
            module:    $module,
            description: "Mengubah {$module}: {$label}",
            subject:   $model,
            oldValues: array_intersect_key($original, $changed),
            newValues: $changed,
        );
    }

    public static function deleted(Model $model, string $module = ''): ActivityLog
    {
        $module = $module ?: static::resolveModule($model);
        $label  = static::resolveLabel($model);
        return static::log(
            action:    'delete',
            module:    $module,
            description: "Menghapus {$module}: {$label}",
            subject:   $model,
            oldValues: $model->getAttributes(),
        );
    }

    // ──────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────

    private static function resolveModule(Model $model): string
    {
        // Ambil nama class terakhir, misal "Produk" dari "App\Models\Master\Produk"
        $parts = explode('\\', get_class($model));
        return end($parts);
    }

    private static function resolveLabel(Model $model): string
    {
        // Coba ambil atribut 'nama', 'name', 'title', 'judul' secara berurutan
        foreach (['nama', 'name', 'title', 'judul', 'no_transaksi', 'kode'] as $attr) {
            if (!empty($model->{$attr})) {
                return (string) $model->{$attr};
            }
        }
        return '#' . $model->getKey();
    }
}
