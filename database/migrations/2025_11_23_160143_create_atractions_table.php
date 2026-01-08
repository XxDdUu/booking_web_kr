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
            $table->string('attractionID', 255)->primary();

            $table->string('serviceID', 255)->unique();
            $table->foreign('serviceID')
                ->references('serviceID')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('locationID', 255);
            $table->foreign('locationID')
                ->references('locationID')  
                ->on('locations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('categoryID', 255);
            $table->foreign('categoryID')
                ->references('categoryID')      
                ->on('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('attractionName', 255);
            $table->text('description')->nullable();
            $table->string('specificType', 255);
            $table->string('category', 255);
            $table->string('duration', 255);
            $table->decimal('rate', 3, 1)->nullable();
            $table->decimal('price', 10, 2);
            $table->json('image');
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
