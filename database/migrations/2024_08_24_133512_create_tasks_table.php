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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->enum('type',['fill','pay','check','observe']);
            $table->enum('status',['pending','inProgress','completed','failed']);

            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages');

            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->foreign('assigned_by')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // $table->unsignedBigInteger('notification_id');
            // $table->foreign('notification_id')->references('id')->on('notification_templates');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
