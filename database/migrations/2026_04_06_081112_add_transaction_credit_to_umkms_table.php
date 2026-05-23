<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            // Total credit purchased/added by superadmin
            $table->unsignedInteger('transaction_credit')->default(0)->after('status');
            // Credit already used (deducted per transaction)
            $table->unsignedInteger('credit_used')->default(0)->after('transaction_credit');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['transaction_credit', 'credit_used']);
        });
    }
};
