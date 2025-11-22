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
        Schema::table('Services', function (Blueprint $table) {
            $table->string('ServiceID', 255)->primary()->unique();
            $table->string('LocationID', 255)
                ->references('LocationID')
                ->on('Location')
                ->onDelete('casade')
                ->onUpdate('casade');
            $table->string('Name', 255);
            $table->text('Description');
            $table->decimal('Price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Services');
    }
};
