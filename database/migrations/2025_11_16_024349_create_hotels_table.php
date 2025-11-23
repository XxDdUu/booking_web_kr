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
        Schema::create('hotels', function (Blueprint $table) {
            // $table->id();
            $table->string('hotel_id', 255)->primary();
            // 1. Xử lý location_id
            $table->string('location_id'); // Tạo cột string thay vì bigInteger
            $table->foreign('location_id')
                ->references('location_id')       // Tên cột khóa chính bên bảng locations
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 2. Xử lý category_id
            $table->string('category_id'); // Tạo cột string thay vì bigInteger
            $table->foreign('category_id')
                ->references('category_id')       // Tên cột khóa chính bên bảng hotel_categories
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            $table->string('hotel_name', 128);
            $table->text('description');
            $table->text('city');
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
