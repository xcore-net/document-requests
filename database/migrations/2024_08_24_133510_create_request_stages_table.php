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
        Schema::create('request_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('request_id');
            $table->unsignedInteger('stage_id');
            $table->unsignedInteger('order');


            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('stage_id')->references('id')->on('stages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_stages');
    }
};
