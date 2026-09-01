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
        Schema::table('events', function (Blueprint $table) {
            $table->string('banner_path')->nullable()->after('description');
            $table->string('category')->nullable()->after('banner_path');
            $table->string('whatsapp_number')->nullable()->after('category');
            $table->string('bank_account')->nullable()->after('whatsapp_number');
            $table->json('custom_services')->nullable()->after('bank_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'banner_path',
                'category',
                'whatsapp_number',
                'bank_account',
                'custom_services'
            ]);
        });
    }
};
