<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_proofs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('attendee_id')->constrained('attendees')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('bank_name', 100); // bank pengirim (BCA, Mandiri, dll)
            $table->string('account_holder_name', 255)->nullable();
            $table->date('transfer_date');
            $table->text('notes')->nullable();
            $table->string('image_path'); // path ke bukti transfer di storage
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignUuid('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        // Tambah enum 'pending_verification' ke tabel attendees
        DB::statement("ALTER TABLE attendees MODIFY COLUMN status ENUM('registered', 'checked_in', 'cancelled', 'pending_payment', 'pending_verification') NOT NULL");
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_proofs');
        DB::statement("ALTER TABLE attendees MODIFY COLUMN status ENUM('registered', 'checked_in', 'cancelled', 'pending_payment') NOT NULL");
    }
};
