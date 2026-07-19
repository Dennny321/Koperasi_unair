<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('print_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('02_transaksi')->onDelete('cascade');
            $table->string('no_nota');
            $table->string('kasir_id')->nullable();

            // Status: pending → processing → done | failed
            $table->enum('status', ['pending', 'processing', 'done', 'failed'])->default('pending');

            // ESC/POS raw bytes dalam base64
            $table->longText('escpos_base64');

            // Identifikasi kasir mana yang boleh ambil job ini
            // null = semua kasir bisa ambil (untuk 1 printer 1 kasir)
            $table->string('printer_target')->nullable();

            $table->timestamp('printed_at')->nullable();
            $table->string('error_message')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('id_transaksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('print_jobs');
    }
};