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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('booking_id')->primary();
            $table->string('user_id');
            // 2. Định nghĩa khoá ngoại
            $table->foreign('user_id')
                ->references('id') // Tên cột khoá chính bên bảng users (thường là id hoặc user_id)
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Tương tự cho services
            $table->string('service_id');
            $table->foreign('service_id')
                ->references('service_id') // Tên cột khoá chính bên bảng services
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->string('status', 50)->default('pending')->check('confirmed', 'cancelled', 'confirmed modified', 'pending');
            $table->string('status', 50)->default('pending')->comment('confirmed, cancelled, confirmed modified, pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
