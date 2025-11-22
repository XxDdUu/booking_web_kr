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
        Schema::create('Bookings', function (Blueprint $table) {
            $table->string('BookingID', 255)->primary();
            $table->foreign('ServiceID', 255)
                ->references('ServiceID')
                ->on('Services')
                ->onDelete('casade')
                ->onUpdate('casade');
            $table->dateTime('Date')->useCurrentOnUpdate();
            $table->string('Status', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Bookings');
    }
};
