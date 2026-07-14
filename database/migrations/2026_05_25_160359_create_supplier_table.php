<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('01_supplier')) {
            Schema::create('01_supplier', function (Blueprint $table) {
                $table->id();
                $table->string('kode_supplier', 50)->unique();
                $table->string('nama');
                $table->string('telepon', 20)->nullable();
                $table->string('email')->nullable();
                $table->text('alamat')->nullable();
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('01_supplier');
    }
};
