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
        Schema::create('eye_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('region')->nullable();
            $table->string('school_cluster')->nullable();
            $table->string('name_of_teacher')->nullable();
            $table->string('student_id')->nullable();
            $table->string('student_name')->nullable();
            $table->string('class')->nullable();
            $table->integer('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('presenting_vision_r')->nullable();
            $table->string('presenting_vision_l')->nullable();
            $table->string('screening_result')->nullable();
            $table->string('eye_conditions_r')->nullable();
            $table->string('eye_conditions_l')->nullable();
            $table->string('first_action_taken')->nullable();


            $table->string('location')->nullable();  // recently updatd
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eye_examinations');
    }
};
