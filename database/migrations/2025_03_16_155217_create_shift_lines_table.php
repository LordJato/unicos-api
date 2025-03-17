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
        Schema::create('shift_lines', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_header_id');
            $table->date('day');
            $table->time('start');
            $table->time('end');
            $table->boolean('is_flexi_time');
            $table->foreign('shift_header_id')->references('id')->on('shift_header')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_lines');
    }
};
