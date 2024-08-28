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

            $table->unsignedBigInteger('department_id'); 
            $table->foreign('department_id')->references('id')->on('departments');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('mother_name');
            $table->string('birthday');
            $table->string('address');
            $table->enum('certificate',['university','institute','baccalaureate','preparatory']);
            $table->integer('national_number');
            $table->integer('salary');
            $table->string('position');


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
