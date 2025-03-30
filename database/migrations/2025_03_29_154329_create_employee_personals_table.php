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
        Schema::create('employee_personals', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->tinyInteger('civil_status_id');
            $table->date('birth_date');
            $table->string('birth_place', 150);
            $table->tinyInteger('sex');
            $table->string('citizenship', 50);
            $table->string('nationality', 50);
            $table->string('religion', 50);
            $table->string('phone', 20);
            $table->string('email', 150);
            $table->string('spouse', 150);
            $table->string('spouse_occupation', 50);
            $table->string('mother', 150);
            $table->string('mother_occupation', 50);
            $table->string('father', 150);
            $table->string('father_occupation', 50);

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_personals');
    }
};
