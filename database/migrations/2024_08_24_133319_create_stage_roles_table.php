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
            $table->unsignedBigInteger('stage_id');
            $table->string('role');

            $table->timestamps();

            $table->foreign('stage_id')->references('id')->on('stage_types');
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
