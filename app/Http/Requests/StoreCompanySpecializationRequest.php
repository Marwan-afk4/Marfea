<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanySpecializationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_id' => 'exists:companies,id',
            'specialization_name' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'company_id.exists' => __('The selected Company is invalid.'),
            'specialization_name.required' => __('The Specialization Name field is required.'),
            'status.required' => __('The Status field is required.')
        ];
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new ValidationException($validator, response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]));
        }

        throw new ValidationException($validator);
    }
}
