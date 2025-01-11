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
        Schema::create('observances', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('observance_type_id');
            $table->unsignedBigInteger('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('title', 100);
            $table->string('description', 200);
            $table->datetime('start_date');
            $table->datetime('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observances');
    }
};
