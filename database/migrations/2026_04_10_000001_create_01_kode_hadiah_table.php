<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Buat tabel 01_kode_hadiah — satu baris per kode hadiah (1 stok = 1 kode).
 * Membutuhkan tabel 01_hadiah dan users yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Tabel sudah ada? Skip
        if (Schema::hasTable('01_kode_hadiah')) {
            return;
        }

        Schema::create('01_kode_hadiah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hadiah');
            $table->unsignedBigInteger('id_member')->nullable();
            $table->string('kode_hadiah', 64)->unique();
            $table->integer('jumlah_poin');
            $table->string('status')->default('tersedia'); // tersedia | diredeem
            $table->timestamps();

            $table->foreign('id_hadiah')
                  ->references('id')
                  ->on('01_hadiah')
                  ->cascadeOnDelete();

            $table->foreign('id_member')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('01_kode_hadiah');
    }
};
