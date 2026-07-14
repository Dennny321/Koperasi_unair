<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();           // snapshot nama user
            $table->string('user_role')->nullable();           // snapshot role user
            $table->string('action', 50);                      // login | logout | create | update | delete | view
            $table->string('module', 100);                     // Produk | User | Transaksi | dll
            $table->string('description')->nullable();         // deskripsi human-readable
            $table->string('subject_type')->nullable();        // App\Models\Master\Produk
            $table->unsignedBigInteger('subject_id')->nullable(); // ID record yang terpengaruh
            $table->string('subject_label')->nullable();       // snapshot nama/label record
            $table->json('old_values')->nullable();            // data sebelum update/delete
            $table->json('new_values')->nullable();            // data sesudah create/update
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 10)->nullable();          // GET | POST | PUT | DELETE
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['module', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};