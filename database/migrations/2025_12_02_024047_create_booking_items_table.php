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
        Schema::create('bookingItems', function (Blueprint $table) {
            $table->string('bookingItemID', 255)->primary();


            $table->string('bookingID', 255);
            $table->foreign('bookingID')
                ->references('bookingID')
                ->on('bookings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('serviceID', 255);
            $table->foreign('serviceID')
                ->references('serviceID')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();

            // ENUM cho loại dịch vụ
            // $table->enum('serviceType', ['stay', 'car', 'attraction']);


            $table->string('serviceType', 50);
            $table->string('stayID')->nullable();
            $table->string('carID')->nullable();
            $table->string('attractionID')->nullable();
            
            $table->string('roomTypeID')->nullable();
            $table->integer('quantity')->default(1);

            $table->decimal('subtotal', 20, 2)->nullable();
            $table->string('status', 255)
                ->default('pending')
                ->comment('pending, confirmed, cancelled, confirmed modified');
            $table->json('metaJson')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookingItems', function (Blueprint $table) {
            //
        });
    }
};
