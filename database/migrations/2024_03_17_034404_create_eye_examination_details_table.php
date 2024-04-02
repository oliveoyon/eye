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
        Schema::create('eye_examination_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eye_examination_id')->constrained()->onDelete('cascade');
            $table->string('vision_information_r')->nullable();
            $table->string('vision_information_l')->nullable();
            $table->string('corrected_vision_r')->nullable();
            $table->string('corrected_vision_l')->nullable();
            $table->string('type_of_correction_spherical_r')->nullable();
            $table->string('type_of_correction_spherical_l')->nullable();
            $table->string('type_of_correction_cylinder_r')->nullable();
            $table->string('type_of_correction_cylinder_l')->nullable();
            $table->string('type_of_correction_axis_r')->nullable();
            $table->string('type_of_correction_axis_l')->nullable();
            $table->string('type_of_error_r')->nullable();
            $table->string('type_of_error_l')->nullable();
            $table->string('other_eye_conditions_r')->nullable();
            $table->string('other_eye_conditions_l')->nullable();
            $table->string('second_action_taken')->nullable();
            $table->string('concluding_diagnosis_r')->nullable();
            $table->string('concluding_diagnosis_l')->nullable();
            $table->string('final_action_taken')->nullable();


            $table->string('refrective_error')->nullable();  //12 yes no
            $table->string('using_screen')->nullable();  //18 yes no
            $table->string('watching_time')->nullable();  //19 a) 1-3     b) 4-6     c)7-9
            $table->string('covid_infected')->nullable();  //20 yes no
            $table->string('eye_prob_online')->nullable();  //21 yes no
            $table->string('conclusion')->nullable();  //22 a) Glass Prescribed b) Refd. for Medication

            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eye_examination_details');
    }
};
