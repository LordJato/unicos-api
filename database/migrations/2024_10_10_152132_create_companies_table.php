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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('name', 100);
            $table->string('address', 150);
            $table->string('city', 50);
            $table->string('province', 30);
            $table->string('postal', 4);
            $table->string('country', 50);
            $table->string('email', 100)->unique();;
            $table->string('phone', 50);
            $table->string('fax', 50)->nullable();
            $table->string('TIN', 20)->nullable();
            $table->string('SSS', 20)->nullable();
            $table->string('PhilHealth', 20)->nullable();
            $table->string('HDMF', 20)->nullable();
            $table->tinyInteger('work_hrs_per_day')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
