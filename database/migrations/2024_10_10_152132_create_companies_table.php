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
            $table->string('tin', 20)->nullable();
            $table->string('sss', 20)->nullable();
            $table->string('philhealth', 20)->nullable();
            $table->string('hdmf', 20)->nullable();
            $table->timestamps();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
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
