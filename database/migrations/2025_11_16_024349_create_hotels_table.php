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
        Schema::create('stays', function (Blueprint $table) {
            // $table->id();
            $table->string('HotelID', 255)->primary();
            // 1. Xử lý locationID
            $table->string('LocationID'); // Tạo cột string thay vì bigInteger
            $table->foreign('LocationID')
                ->references('LocationID')       // Tên cột khóa chính bên bảng locations
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 2. Xử lý categoryID
            $table->string('CategoryID'); // Tạo cột string thay vì bigInteger
            $table->foreign('CategoryID')
                ->references('CategoryID')       // Tên cột khóa chính bên bảng hotel_categories
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->string('HotelName', 128);
            $table->text('Description');
            $table->string('Location',128);
            $table->date('checkIn');
            $table->date('checkOut');
            $table->text('Image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
