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
        Schema::create('attractions', function (Blueprint $table) {
            $table->string('attractionID',255)->primary();
            $table->string('serviceID',255);
            $table->string('locationID',255);
            $table->string('categoryID',255);
            $table->string('atractionName',255);
            $table->text('description')->nullable();
            $table->string('specificType',255);
            $table->string('category',255);
            $table->string('duration',255);
            $table->decimal('rate',3,1);
            $table->decimal('price',8,2);
            $table->string('image',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
