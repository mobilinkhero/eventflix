<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('event_type'); // wedding, birthday, corporate, mehndi, etc.
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->integer('guest_count')->nullable();
            $table->text('requirements')->nullable();
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->decimal('final_price', 12, 2)->nullable();
            $table->decimal('advance_paid', 12, 2)->default(0);
            $table->enum('status', [
                'pending',      // Just submitted
                'viewed',       // Vendor has seen it
                'quoted',       // Vendor sent a quote
                'confirmed',    // User accepted & confirmed
                'in_progress',  // Event day
                'completed',    // Event done
                'cancelled',    // Cancelled by either party
                'rejected',     // Vendor rejected
            ])->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index(['event_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
