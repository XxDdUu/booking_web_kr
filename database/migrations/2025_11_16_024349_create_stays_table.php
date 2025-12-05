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
            $table->string('stayID', 255)->primary();
            // 1. Xử lý locationID
            $table->string('locationID'); // Tạo cột string thay vì bigInteger
            $table->foreign('locationID')
                ->references('locationID')       // Tên cột khóa chính bên bảng locations
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 2. Xử lý categoryID
            $table->string('categoryID'); // Tạo cột string thay vì bigInteger
            $table->foreign('categoryID')
                ->references('categoryID')       // Tên cột khóa chính bên bảng hotel_categories
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('serviceID'); // Tạo cột string thay vì bigInteger
            $table->foreign('serviceID')
                ->references('serviceID')       // Tên cột khóa chính bên bảng hotel_categories
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('stayName', 255);
            $table->text('description')->nullable();
            $table->string('location', 128);
            $table->string('address', 255);
            $table->decimal('rating', 2, 1);
            $table->text('image')->nullable();
            $table->decimal('price', 8, 2);
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
