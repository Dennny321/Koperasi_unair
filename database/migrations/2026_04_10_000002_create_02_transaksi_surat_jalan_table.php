<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Buat tabel 02_transaksi_surat_jalan dan 02_detail_transaksi_surat_jalan.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('02_transaksi_surat_jalan')) {
            Schema::create('02_transaksi_surat_jalan', function (Blueprint $table) {
                $table->id();
                $table->string('no_transaksi', 64)->unique();
                $table->unsignedBigInteger('id_kasir');
                $table->string('no_surat', 64)->unique();
                $table->string('tujuan');
                $table->text('keterangan')->nullable();
                $table->string('status')->default('draft'); // draft | dicetak | selesai
                $table->string('file')->nullable();
                $table->decimal('total_harga', 15, 2)->default(0);
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('id_kasir')
                      ->references('id')
                      ->on('users')
                      ->restrictOnDelete();
            });
        }

        if (!Schema::hasTable('02_detail_transaksi_surat_jalan')) {
            Schema::create('02_detail_transaksi_surat_jalan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_transaksi');
                $table->unsignedBigInteger('id_produk');
                $table->integer('jumlah');
                $table->decimal('harga_satuan', 15, 2);
                $table->decimal('subtotal', 15, 2);

                $table->foreign('id_transaksi')
                      ->references('id')
                      ->on('02_transaksi_surat_jalan')
                      ->cascadeOnDelete();

                $table->foreign('id_produk')
                      ->references('id')
                      ->on('01_produk')
                      ->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('02_detail_transaksi_surat_jalan');
        Schema::dropIfExists('02_transaksi_surat_jalan');
    }
};
