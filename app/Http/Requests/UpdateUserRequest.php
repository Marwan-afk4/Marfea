<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'password' => 'sometimes',
            'phone' => 'sometimes|string',
            'image' => 'sometimes',
            'status' => 'sometimes|in:active,inactive',
            'specialization' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'first_name.string' => 'The first name must be a string.',
            'last_name.string' => 'The last name must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'phone.numeric' => 'The phone number must be a numeric value.',
            'password.string' => 'The password must be a string.',
            'image.string' => 'The image must be a string.',
            'status.in' => 'The status must be active or inactive.',
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
