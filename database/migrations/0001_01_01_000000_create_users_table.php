<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->timestamp('last_active')->nullable();
            $table->enum('type', ['admin', 'seeker', 'provider'])->default('seeker');
            $table->text('image')->nullable();
            $table->text('identity_card')->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->bigInteger('coutry_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(0);
            $table->bigInteger('job_id')->nullable();
            $table->bigInteger('sub_categories_id')->nullable();
            $table->bigInteger('years_experience')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
