<?php

namespace App\Http\Requests;

use App\Models\HealthWorker;
use Illuminate\Foundation\Http\FormRequest;

class HealthWorkerRequest extends FormRequest
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
        $rules = HealthWorker::VALIDATION_RULES;
        if ($this->getMethod() == 'POST') {
            $rules += ['password' => 'required'];
        } else {
            $rules['email'][1] = 'unique:users,email,' . request()->route('user')->id;
        }
        return $rules;
    }
}
