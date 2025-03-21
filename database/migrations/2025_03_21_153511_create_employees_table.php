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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('employee_type_id');
            $table->unsignedBigInteger('employee_status_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('shift_id');
            $table->string('id_no', 20);
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('middlename', 50);
            $table->date('date_hired');
            $table->date('date_resigned');
            $table->date('date_terminated');
            $table->string('tin', 30);
            $table->string('sss', 30);
            $table->string('pagibig', 30);
            $table->string('philhealth', 30);
            $table->mediumInteger('ecola');
            $table->mediumInteger('basic_salary');
            $table->mediumInteger('hourly_rate');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('employee_type_id')->references('id')->on('employee_types')->onDelete('cascade');
            $table->foreign('employee_status_id')->references('id')->on('employee_statuses')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('shift_header_id')->references('id')->on('shift_headers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
