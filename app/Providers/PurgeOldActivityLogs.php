<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

/**
 * Artisan command untuk menghapus log aktivitas yang sudah >= 3 bulan.
 *
 * Jalankan manual:
 *   php artisan activity-log:purge
 *
 * Jadwalkan otomatis di app/Console/Kernel.php:
 *   $schedule->command('activity-log:purge')->monthly();
 */
class PurgeOldActivityLogs extends Command
{
    protected $signature   = 'activity-log:purge {--dry-run : Hitung saja tanpa benar-benar menghapus}';
    protected $description = 'Hapus log aktivitas yang sudah berumur lebih dari 3 bulan';

    public function handle(): int
    {
        $count = ActivityLog::olderThan3Months()->count();

        if ($count === 0) {
            $this->info('Tidak ada log aktivitas yang berumur lebih dari 3 bulan.');
            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->warn("[DRY RUN] Akan menghapus {$count} log aktivitas.");
            return self::SUCCESS;
        }

        if (!$this->confirm("Akan menghapus {$count} log aktivitas. Lanjutkan?")) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        ActivityLog::olderThan3Months()->delete();
        $this->info("Berhasil menghapus {$count} log aktivitas.");

        return self::SUCCESS;
    }
}
