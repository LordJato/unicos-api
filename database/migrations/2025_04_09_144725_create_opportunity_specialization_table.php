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
        Schema::create('opportunity_specialization', function (Blueprint $table) {
            $table->unsignedBigInteger('opportunity_id');
            $table->unsignedBigInteger('specialization_id');

            $table->foreign('opportunity_id')
                ->references('id')->on('opportunities')
                ->onDelete('cascade');

            $table->foreign('specialization_id')
                ->references('id')->on('specializations')
                ->onDelete('cascade');

            $table->primary(['opportunity_id', 'specialization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_specialization');
    }
};
