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
            $table->unsignedBigInteger('request_type_id'); 
            $table->foreign('request_type_id')->references('id')->on('request_types');

            $table->unsignedBigInteger('stage_type_id'); 
            $table->foreign('stage_type_id')->references('id')->on('stage_types');

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
