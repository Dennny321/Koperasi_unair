<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Update tabel 02_riwayat_poin — tambah kolom id_penukaran_kode & jenis_keterangan.
 * Migration ini aman dijalankan kapanpun — skip jika tabel belum ada, skip jika kolom sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Skip jika tabel riwayat_poin belum ada sama sekali
        if (!Schema::hasTable('02_riwayat_poin')) {
            return;
        }

        Schema::table('02_riwayat_poin', function (Blueprint $table) {
            // Kolom id_penukaran_kode
            if (!Schema::hasColumn('02_riwayat_poin', 'id_penukaran_kode')) {
                $table->unsignedBigInteger('id_penukaran_kode')
                      ->nullable()
                      ->after('id_penukaran');

                // Tambah FK hanya jika tabel 01_kode_hadiah sudah ada
                if (Schema::hasTable('01_kode_hadiah')) {
                    $table->foreign('id_penukaran_kode')
                          ->references('id')
                          ->on('01_kode_hadiah')
                          ->nullOnDelete();
                }
            }

            // Kolom jenis_keterangan
            if (!Schema::hasColumn('02_riwayat_poin', 'jenis_keterangan')) {
                $table->string('jenis_keterangan')
                      ->nullable()
                      ->after('keterangan');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('02_riwayat_poin')) {
            return;
        }

        Schema::table('02_riwayat_poin', function (Blueprint $table) {
            if (Schema::hasColumn('02_riwayat_poin', 'id_penukaran_kode')) {
                try {
                    $table->dropForeign(['id_penukaran_kode']);
                } catch (\Exception $e) {
                    // FK mungkin tidak ada, abaikan
                }
                $table->dropColumn('id_penukaran_kode');
            }

            if (Schema::hasColumn('02_riwayat_poin', 'jenis_keterangan')) {
                $table->dropColumn('jenis_keterangan');
            }
        });
    }
};
