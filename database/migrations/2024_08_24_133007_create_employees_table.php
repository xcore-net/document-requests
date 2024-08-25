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
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('dept_id');
            $table->double('salary');
            $table->enum('position',['Junior','Senior']);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users');
            $table->foreign('dept_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
