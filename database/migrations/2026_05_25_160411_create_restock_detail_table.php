<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('02_restock_detail')) {
            Schema::create('02_restock_detail', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_restock');
                $table->unsignedBigInteger('id_produk');
                $table->integer('jumlah');
                $table->decimal('harga_beli', 12, 2); // harga beli per unit
                $table->decimal('subtotal', 15, 2); // jumlah × harga_beli
                $table->text('catatan')->nullable();
                $table->timestamps();


                $table->foreign('id_restock')
                    ->references('id')
                    ->on('01_restock')
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
        Schema::dropIfExists('02_restock_detail');
    }
};
