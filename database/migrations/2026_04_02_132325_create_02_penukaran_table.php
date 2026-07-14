<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('02_penukaran')) { return; }
        Schema::create('02_penukaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_hadiah');
            $table->integer('poin_digunakan');
            $table->string('kode_unik', 64)->unique();
            $table->string('status')->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->restrictOnDelete();

            $table->foreign('id_hadiah')
                  ->references('id')
                  ->on('01_hadiah')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('02_penukaran');
    }
};