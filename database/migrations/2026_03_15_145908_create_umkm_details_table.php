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
        Schema::create('umkm_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->unique()->constrained()->onDelete('cascade');
            
            // Bio/Deskripsi Panjang
            $table->text('description')->nullable();
            
            // Legalitas (Simpan path file)
            $table->string('npwp_file_path')->nullable();
            $table->string('nib_file_path')->nullable();
            $table->string('ktp_file_path')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact_person')->nullable(); // Nama owner/PJ

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_details');
    }
};
