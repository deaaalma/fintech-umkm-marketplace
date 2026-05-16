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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penerima notif
            $table->string('title');
            $table->text('message');
            $table->string('type'); // e.g., 'invoice', 'order_update', 'system'
            $table->string('link')->nullable(); // URL tujuan saat diklik
            $table->timestamp('read_at')->nullable(); // Untuk membedakan belum/sudah dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
