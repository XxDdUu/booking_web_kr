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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string('Name',255)->nullable(false);
            $table->string('Email',255)->unique()->nullable();
            $table->string('Phone',255)->unique()->nullable();
            $table->string('Language',10)->nullable(false)->default('en');
            $table->string('avatar_url',255)->nullable()->unique(); // make nullable
            $table->string('role', 50)->nullable(false)->default('customer')->check('staff', 'customer', 'admin');
            /****   ***/
            $table->string('Password', 255)->nullable(false);
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
        Schema::dropIfExists('password_reset_tokens'); // ensure this is dropped
        Schema::dropIfExists('users');
    }
};
