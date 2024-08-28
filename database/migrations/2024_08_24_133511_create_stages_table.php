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
            $table->unsignedBigInteger('filled_form_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            
            $table->enum('status',['inProgress','completed','failed']);
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('filled_form_id')->references('id')->on('filled_forms');
            $table->foreign('payment_id')->references('id')->on('payments');
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
