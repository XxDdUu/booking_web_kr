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
        Schema::table('Location', function (Blueprint $table) {
            $table->string('LocationID',255)->primary();
            $table->string('Name',255);
            $table->string('Adress',255);
            $table->string('City',128);
            $table->string('Country',128);
            $table->string('PinCode',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::dropIfExits('Location');
    }
};
