<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|unique:users,phone',
            // 'email_code' => 'required',
            // 'email_verified' => 'required',
            'image' => 'nullable',
            'status' => 'required|in:active,inactive',
            // 'role' => 'required',
            // 'id_token' => 'required',
            'specialization'=>'required',
            'company_id'=>'required|exists:companies,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required.',
            'phone.required' => 'The phone number is required.',
            'image.required' => 'The image is required.',
            'status.required' => 'The status is required.',
            'specialization.required' => 'The specialization is required.',
            'company_id.required' => 'The company id is required.',
            'company_id.exists' => 'The company id does not exist.',
            'email.unique' => 'The email has already been taken.',
            'phone.unique' => 'The phone number has already been taken.',
            'phone.numeric' => 'The phone number must be a numeric value.',
            'email.email' => 'The email must be a valid email address.',
            'password.min' => 'The password must be at least 8 characters.',
            'status.in' => 'The status must be active or inactive.',
            'first_name.string' => 'The first name must be a string.',
            'last_name.string' => 'The last name must be a string.',
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
