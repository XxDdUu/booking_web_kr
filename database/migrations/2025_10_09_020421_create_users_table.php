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
            $table->string('UserID', 255)->primary();
            $table->string('Name',255)->nullable(false);
            $table->string('Email',255)->unique();
            $table->string('Phone',255)->unique();
            # google auth
            $table->string('google_id', 255)->nullable(false)->unique();
            $table->string('avatar_url',255)->nullable(false)->unique();
            $table->string('provider',50)-> nullable(false)->unique();
            /****   ***/
            $table->string('Password', 255)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
