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
            $table->string('ServiceID', 255)->primary();

            $table->string('LocationID'); // Tạo cột string thay vì bigInteger
            $table->foreign('LocationID')
                ->references('LocationID')       // Tên cột khóa chính bên bảng locations
                ->on('locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('Name', 255);
            $table->text('Description');
            $table->decimal('Price', 10, 2)->default(0);
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
