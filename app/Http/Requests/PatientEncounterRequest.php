<?php

namespace App\Http\Requests;

use App\Models\PatientEncounter;
use Illuminate\Foundation\Http\FormRequest;

class PatientEncounterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = PatientEncounter::VALIDATION_RULES;
        // if ($this->getMethod() == 'POST') {
        //     $rules += ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'];
        //     $rules += ['password' => 'required'];
        // } else {
        //     $rules['email'][1] = 'unique:users,email,' . request()->route('user')->id;
        // }
        return $rules;
    }
}
