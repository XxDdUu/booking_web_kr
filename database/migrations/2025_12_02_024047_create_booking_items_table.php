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
        Schema::create('booking_items', function (Blueprint $table) {
            $table->string('bookingItemID',255);

            // Khóa ngoại liên kết với bảng bookings
            // onDelete('cascade') giúp xóa item nếu booking bị xóa
            $table->string('bookingID', 255);
            $table->foreign('bookingID')
                ->references('bookingID')
                ->on('bookings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // ID của dịch vụ (ID khách sạn, ID xe, ID vé tham quan...)
            // Index cụm (service_type + service_id) giúp query nhanh hơn
            $table->string('serviceID',255);
            $table->foreign('serviceID')
                ->references('serviceID')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('quantity')->default(1);

            // Dùng Decimal cho tiền tệ để tránh lỗi làm tròn số thực (floating point)
            // 15 số, 2 số thập phân
            $table->decimal('subtotal', 20, 2);
            $table->string('paymentStatus',255)->default('pending');

            // Cột Meta dạng JSON, cho phép NULL nếu không có dữ liệu thêm
            $table->json('metaJson')->nullable();

            $table->timestamps();

            // Đánh index để tối ưu hiệu suất tìm kiếm
            // $table->index(['serviceType', 'serviceID']);
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
