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
        Schema::create('carRentals', function (Blueprint $table) {
            $table->string('carRentalID',255)->primary();

            $table->string('serviceID',255);
            $table->foreign('serviceID')
                ->references('serviceID')
                ->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('locationID',255);
            $table->foreign('locationID')
                ->references('locationID')
                ->on('locations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('carID',255);
            $table->foreign('carID')
                ->references('carID')
                ->on('cars')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('carName',255);
            $table->text('checkInDestination');
            $table->decimal('price',15,2);
            $table->decimal('rate',3,1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rentals');
    }
};
