<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
    if (!Schema::hasTable('01_restock')) {
       Schema::create('01_restock', function (Blueprint $table) {
           $table->id();
           $table->string('kode_restock', 50)->unique();
           $table->date('tanggal_restock');
           $table->unsignedBigInteger('id_supplier')->nullable();
           $table->unsignedBigInteger('id_user'); // user yang melakukan restock
           $table->text('keterangan')->nullable();
           $table->decimal('total_biaya', 15, 2)->default(0);
           $table->enum('status', ['draft', 'selesai', 'dibatalkan'])->default('draft');
           $table->timestamps();


           $table->foreign('id_supplier')
                 ->references('id')
                 ->on('01_supplier')
                 ->nullOnDelete();


           $table->foreign('id_user')
                 ->references('id')
                 ->on('users')
                 ->restrictOnDelete();
       });
   }
}


   public function down(): void
   {
       Schema::dropIfExists('01_restock');
   }
};




