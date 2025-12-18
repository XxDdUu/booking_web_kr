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
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('roomID',255)->primary();

            $table->string('stayID',255);
            $table->foreign('stayID')
                ->references('stayID')
                ->on('stays')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('roomTypeID',255);
            $table->foreign('roomTypeID')
                ->references('roomTypeID')
                ->on('roomTypes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('roomName',255)->nullable();
            $table->string('description',255)->nullable();
            $table->tinyInteger('quantity',false,true)->nullable();
            $table->decimal('currentPrice',15,2)->nullable();
            $table->string('availability',50)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
