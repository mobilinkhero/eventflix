<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('price_min', 12, 2)->default(0);
            $table->decimal('price_max', 12, 2)->default(0);
            $table->string('price_unit')->default('event'); // per event, per hour, per day
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('total_bookings')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['city_id', 'is_active', 'status']);
            $table->index(['is_featured', 'is_active']);
            $table->index(['rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
