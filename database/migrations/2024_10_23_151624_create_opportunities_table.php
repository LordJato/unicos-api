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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('opportunity_type_id');
            $table->mediumInteger('designation_id');
            $table->tinyInteger('career_level_id');
            $table->string('title', 100);
            $table->string('slug', 150);
            $table->string('description', 200);
            $table->string('location', 150);
            $table->tinyInteger('schedule');
            $table->tinyInteger('years_of_experience');
            $table->tinyInteger('vacancy');
            $table->tinyInteger('opportunity_status_id');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('opportunity_type_id')->references('id')->on('opportunity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
