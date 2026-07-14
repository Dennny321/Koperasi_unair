<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('01_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori_produk');
            $table->string('kode_produk', 50)->unique();
            $table->string('nama');
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(0);
            $table->decimal('harga', 12, 2);
            $table->string('foto')->nullable();
            $table->string('satuan', 20);
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori_produk')
                  ->references('id')
                  ->on('01_kategori_produk')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('01_produk');
    }
};