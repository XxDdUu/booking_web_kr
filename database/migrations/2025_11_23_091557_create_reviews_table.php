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
        Schema::create('reviews', function (Blueprint $table) {
            // $table->id();
            $table->string('review_id',255)->primary();

            $table->string('location_id',255);
            $table->foreign('location_id')
                ->references('location_id')
                ->on('locations')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('service_id',255);
            $table->foreign('service_id')
                ->references('service_id')
                ->on('services')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
