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
            $table->unsignedBigInteger('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('opportunity_type_id')->references('id')->on('opportunity_types')->onDelete('cascade');
            $table->tinyInteger('opportunity_status_id');
            $table->mediumInteger('designation_id');
            $table->tinyInteger('career_level_id');
            $table->timestamps();
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
