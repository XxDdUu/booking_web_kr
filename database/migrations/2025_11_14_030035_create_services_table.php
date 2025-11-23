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
        Schema::create('services', function (Blueprint $table) {
            $table->string('service_id', 255)->primary();

            $table->string('location_id'); // Tạo cột string thay vì bigInteger
            $table->foreign('location_id')
                ->references('location_id')       // Tên cột khóa chính bên bảng locations
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('name', 255);
            $table->text('description');
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
