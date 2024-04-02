<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EyeExaminationDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'eye_examination_id',
        'vision_information_r',
        'vision_information_l',
        'corrected_vision_r',
        'corrected_vision_l',
        'type_of_correction_spherical_r',
        'type_of_correction_spherical_l',
        'type_of_correction_cylinder_r',
        'type_of_correction_cylinder_l',
        'type_of_correction_axis_r',
        'type_of_correction_axis_l',
        'type_of_error_r',
        'type_of_error_l',
        'other_eye_conditions_r',
        'other_eye_conditions_l',
        'second_action_taken',
        'concluding_diagnosis_r',
        'concluding_diagnosis_l',
        'final_action_taken',
        // Add other fields as needed
    ];
}
