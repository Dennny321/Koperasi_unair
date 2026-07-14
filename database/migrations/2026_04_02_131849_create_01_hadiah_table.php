<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('01_hadiah')) { return; }
        Schema::create('01_hadiah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('biaya_poin');
            $table->integer('stok')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('01_hadiah');
    }
};