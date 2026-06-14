<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('cancellation_reason')->nullable()->after('notes');
            $table->enum('cancellation_requested_by', ['customer', 'admin'])->nullable()->after('cancellation_reason');
            $table->string('previous_status')->nullable()->after('cancellation_requested_by');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cancellation_reason', 'cancellation_requested_by', 'previous_status']);
        });
    }
};
