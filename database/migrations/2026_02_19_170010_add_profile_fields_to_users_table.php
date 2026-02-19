<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->foreignId('city_id')->nullable()->after('avatar')->constrained()->nullOnDelete();
            $table->enum('account_type', ['user', 'vendor', 'admin'])->default('user')->after('city_id');
            $table->boolean('is_active')->default(true)->after('account_type');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['phone', 'avatar', 'city_id', 'account_type', 'is_active', 'phone_verified_at']);
        });
    }
};
