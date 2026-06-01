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
        Schema::table('umkms', function (Blueprint $table) {
            // $table->string('tagline')->nullable()->after('name');
            $table->string('instagram_url')->nullable()->after('name');
            $table->string('whatsapp_number')->nullable()->after('instagram_url');
            $table->string('facebook_url')->nullable()->after('whatsapp_number');
            $table->string('website_url')->nullable()->after('facebook_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'instagram_url', 'whatsapp_number', 'facebook_url', 'website_url']);
        });
    }
};
