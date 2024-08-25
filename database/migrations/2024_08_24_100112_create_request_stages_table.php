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
            $table->unsignedBigInteger('request_id'); 
            $table->foreign('request_id')->references('id')->on('requests');

            $table->unsignedBigInteger('stage_id'); 
            $table->foreign('stage_id')->references('id')->on('stages');

            $table->integer('number');
            $table->enum('status',['inprogress','completed']);
            $table->timestamps();
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
