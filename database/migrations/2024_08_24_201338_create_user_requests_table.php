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
        Schema::create('client_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('request_id');
            $table->enum('status',['pending','inProgress','completed','rejected']);

            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('request_id')->references('id')->on('requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_requests');
    }
};
