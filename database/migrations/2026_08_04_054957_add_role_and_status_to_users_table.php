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
        Schema::table('users', function (Blueprint $table) {
            // role: 'user' (pembeli tiket biasa), 'organizer' (pembuat event/tiket), 'admin' (pengatur seluruh sistem)
            $table->string('role', 20)->default('user')->after('email');
            
            // organizer_status: 'none' (user biasa), 'pending' (mengajukan jadi organizer), 'approved' (disetujui admin), 'rejected' (ditolak)
            $table->string('organizer_status', 20)->default('none')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'organizer_status']);
        });
    }
};
