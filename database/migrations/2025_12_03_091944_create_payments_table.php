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
        Schema::create('payments', function (Blueprint $table) {
            // 1. PK: PaymentID (VARCHAR 255)
            // Vì bạn muốn ID là chuỗi (có thể là UUID hoặc Mã tự sinh), ta dùng string và set làm primary
            $table->string('paymentID', 255)->primary();

            // 2. FK: BookingID (VARCHAR 255)
            // Phải cùng kiểu dữ liệu với ID của bảng bookings (String)
            $table->string('bookingID', 255);
            $table->foreign('bookingID')
                ->references('bookingID')
                ->on('bookings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 3. Amount (DECIMAL 10, 2)
            $table->decimal('amount', 20, 2);

            // 4. PaymentDate (DATETIME)
            // Dùng dateTime hoặc timestamp đều được
            $table->timestamp('paymentDate');

            // 5. PaymentMethod (VARCHAR 100)
            $table->string('paymentMethod', 100);

            // 6. TransactionID 
            // Trong hình không ghi kiểu, nhưng thường là chuỗi.
            // Nên để nullable() vì lúc mới tạo (Pending) có thể chưa có mã giao dịch từ ngân hàng.
            $table->string('transactionID', 255)->nullable();

            // 7. Status (VARCHAR 50) + Default 'Pending'
            // Cách 1: Dùng Enum của DB (ít linh hoạt hơn)
            // $table->enum('status', ['Pending', 'Successful', 'Failed'])->default('Pending');

            // Cách 2: Dùng String + Quản lý bằng Code (Khuyên dùng)
            $table->string('status', 50)->default('Pending');

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
