<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah status 'pending_payment' ke enum attendees.
     * Dipakai untuk event berbayar yang belum di-approve pembayarannya.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE attendees MODIFY COLUMN status ENUM('registered', 'checked_in', 'cancelled', 'pending_payment') NOT NULL DEFAULT 'registered'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE attendees MODIFY COLUMN status ENUM('registered', 'checked_in', 'cancelled') NOT NULL DEFAULT 'registered'");
    }
};
