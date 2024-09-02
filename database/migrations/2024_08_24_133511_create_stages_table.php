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
            $table->unsignedInteger('order');
            $table->string('role');
            $table->string('type');
            $table->boolean('isForClient');
            $table->enum('status',['pending','inProgress','completed','failed'])->default('pending');

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
