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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();

            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('bill_id')->references('id')->on('bills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
