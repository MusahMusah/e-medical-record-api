<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEncounter extends Model
{
    use HasFactory;
    // General Validation Rules for all Requests type
    public const VALIDATION_RULES = [
        'date'          =>  'required',
        'time'          =>  'required',
        'visit_type'    =>  'required',
        'weight'        =>  'required',
        'height'        =>  'required',
        'bmi'           =>  'required',
        'bp'            =>  'required',
        'temp'          =>  'required',
        'respiratory_rate'  =>  'required',
        'complaints'        =>  'required',
        'diagnosis'         =>  'required',
        'treatment_plan'    =>  'required',
    ];

}
