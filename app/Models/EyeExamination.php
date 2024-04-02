<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EyeExamination extends Model
{
    use HasFactory;
    protected $fillable = [
        'region',
        'school_cluster',
        'name_of_teacher',
        'student_id',
        'student_name',
        'class',
        'age',
        'sex',
        'father_name',
        'father_occupation',
        'presenting_vision_r',
        'presenting_vision_l',
        'screening_result',
        'eye_conditions_r',
        'eye_conditions_l',
        'first_action_taken',
        // Add other fields here
    ];
}
