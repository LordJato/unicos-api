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
        Schema::create('opportunity_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('opportunity_category_id');
            $table->string('name', 100);
            $table->string('slug', 150);
            $table->timestamps();


            $table->foreign('opportunity_category_id')->references('id')->on('opportunity_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_types');
    }
};
