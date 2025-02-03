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
        Schema::create('account_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->string('slug', 100);
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('account_type_id');
            $table->string('name', 100);
            $table->timestamps();
            $table->boolean('is_active')->default(true);

            $table->foreign('account_type_id')->references('id')->on('account_types')->onDelete('cascade');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_types');
    }
};
