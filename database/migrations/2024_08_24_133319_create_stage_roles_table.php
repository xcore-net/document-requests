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
        Schema::create('stage_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('stage_id');
            $table->unsignedInteger('role_id');

            $table->timestamps();

            $table->foreign('stage')->references('id')->on('stages');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_roles');
    }
};
