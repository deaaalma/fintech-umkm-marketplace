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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->cascadeOnDelete();
            $table->string('type'); // Tambahan kolom type
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('estimated_price', 15, 2)->nullable(); // Harga katalog/awal
            $table->integer('duration_minutes')->nullable(); // Estimasi lama pengerjaan
            $table->string('thumbnail_url')->nullable(); // Foto utama
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
