<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('01_produk', function (Blueprint $table) {
            $table->integer('stok')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('01_produk', function (Blueprint $table) {
            $table->integer('stok')->nullable(false)->change();
        });
    }
};