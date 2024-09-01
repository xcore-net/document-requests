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
        Schema::create('filled_forms', function (Blueprint $table) {
            $table->id();
           

            $table->unsignedBigInteger('form_id'); 
            $table->foreign('form_id')->references('id')->on('forms');

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
        Schema::dropIfExists('filled_forms');
    }
};
