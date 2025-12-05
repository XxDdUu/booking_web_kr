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
            $table->string('name',255)->nullable();
            $table->string('email',255)->unique()->nullable();
            $table->string('phone',255)->unique()->nullable();
            $table->string('language',10)->nullable(false)->default('en');
            $table->string('avatar_path',255)->nullable();
            $table->string('role', 50)
            ->default('customer')
            ->check("role IN ('staff', 'customer', 'admin')");
            /****   ***/
            $table->string('password', 255)->nullable(false);
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
