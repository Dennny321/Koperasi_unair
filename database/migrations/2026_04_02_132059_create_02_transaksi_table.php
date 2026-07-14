<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('02_transaksi')) { return; }
        Schema::create('02_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 50)->unique();
            $table->unsignedBigInteger('id_kasir');
            $table->unsignedBigInteger('id_member')->nullable();
            $table->decimal('total_harga', 12, 2);
            $table->decimal('total_bayar', 12, 2);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->string('metode_bayar')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_kasir')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            $table->foreign('id_member')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('02_transaksi');
    }
};