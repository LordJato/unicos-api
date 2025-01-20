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
        Schema::create('opportunity_benefits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opportunity_id')->references('id')->on('opportunities')->onDelete('cascade');
            $table->string('description', 150);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_benefits');
    }
};
