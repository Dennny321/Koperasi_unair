<?php

namespace App\Traits;

use App\Services\ActivityLogger;

/**
 * Trait HasActivityLog
 *
 * Tambahkan trait ini ke Model manapun untuk mencatat aktivitas CRUD secara otomatis.
 *
 * Penggunaan:
 *   use App\Traits\HasActivityLog;
 *   class Produk extends Model {
 *       use HasActivityLog;
 *   }
 *
 * Opsional — override nama modul di model:
 *   protected string $activityModule = 'Produk';
 *
 * Opsional — exclude kolom dari log:
 *   protected array $activityHidden = ['password', 'remember_token'];
 */
trait HasActivityLog
{
    public static function bootHasActivityLog(): void
    {
        static::created(function ($model) {
            ActivityLogger::created($model, $model->activityModule ?? '');
        });

        static::updated(function ($model) {
            ActivityLogger::updated($model, $model->getOriginal(), $model->activityModule ?? '');
        });

        static::deleted(function ($model) {
            ActivityLogger::deleted($model, $model->activityModule ?? '');
        });
    }
}