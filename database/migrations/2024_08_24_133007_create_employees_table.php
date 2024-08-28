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
            $table->unsignedBigInteger('id')->primary();
            $table->foreign('id')->references('id')->on('users');

            $table->unsignedBigInteger('dept_id');
            $table->foreign('dept_id')->references('id')->on('departments');

            $table->double('salary');
            $table->enum('position', ['Junior', 'Senior']);
            $table->timestamps();
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
