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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->nullable(); // Generate saat status paid
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('umkm_id')->constrained('umkms');
            $table->foreignId('product_id')->constrained('products'); // Mengarah ke products
            $table->date('booking_date')->nullable(); // Wajib H-1
            $table->time('booking_time')->nullable();
            $table->text('service_address')->nullable();
            $table->decimal('service_latitude', 10, 8)->nullable(); // Normalisasi koordinat
            $table->decimal('service_longitude', 11, 8)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('agreed_price', 15, 2)->nullable(); // Harga final kesepakatan
            $table->decimal('platform_fee', 15, 2)->nullable(); // Pendapatan Aplikasi
            $table->decimal('umkm_net_income', 15, 2)->nullable(); // Pendapatan UMKM
            $table->enum('status', ['pending_valuation', 'waiting_payment', 'paid', 'processing', 'completed', 'cancelled'])->default('pending_valuation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
