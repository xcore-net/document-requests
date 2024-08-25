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
            $table->unsignedInteger('form_id');
            $table->unsignedInteger('user_id');

            $table->timestamps();
            
            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('user_id')->references('id')->on('users');
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
