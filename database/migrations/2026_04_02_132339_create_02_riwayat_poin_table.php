<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('02_riwayat_poin')) { return; }
        Schema::create('02_riwayat_poin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->unsignedBigInteger('id_penukaran')->nullable();
            $table->integer('poin');
            $table->string('jenis');
            $table->string('keterangan')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            $table->foreign('id_transaksi')
                  ->references('id')
                  ->on('02_transaksi')
                  ->nullOnDelete();

            $table->foreign('id_penukaran')
                  ->references('id')
                  ->on('02_penukaran')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('02_riwayat_poin');
    }
};