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
        Schema::create('order_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained('users');
            $table->text('admin_instructions')->nullable();
            $table->decimal('worker_fee', 15, 2)->nullable();
            $table->boolean('is_fee_disbursed')->default(false); // Status apakah gaji sdh ditransfer Admin
            $table->timestamp('assigned_at')->nullable();
            $table->string('status')->nullable(); // scheduled, on_the_way, working, done
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_assignments');
    }
};
