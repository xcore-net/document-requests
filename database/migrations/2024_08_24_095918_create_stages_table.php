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
            $table->string('title');
            $table->unsignedBigInteger('stage_type_id'); 
            $table->foreign('stage_type_id')->references('id')->on('stage_types');

            // $table->unsignedBigInteger('payment_id'); 
            // $table->foreign('payment_id')->references('id')->on('payments');

            // $table->unsignedBigInteger('filled_form_id'); 
            // $table->foreign('filled_form_id')->references('id')->on('filled_forms');

            $table->unsignedBigInteger('request_id'); 
            $table->foreign('request_id')->references('id')->on('requests');
            $table->timestamps();
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
