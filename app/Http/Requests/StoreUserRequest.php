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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'email_code' => 'required',
            'email_verified' => 'required',
            'image' => 'required',
            'status' => 'required',
            'role' => 'required',
            'id_token' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('The First Name field is required.'),
            'last_name.required' => __('The Last Name field is required.'),
            'email.required' => __('The Email field is required.'),
            'password.required' => __('The Password field is required.'),
            'phone.required' => __('The Phone field is required.'),
            'email_code.required' => __('The Email Code field is required.'),
            'email_verified.required' => __('The Email Verified field is required.'),
            'image.required' => __('The Image field is required.'),
            'status.required' => __('The Status field is required.'),
            'role.required' => __('The Role field is required.'),
            'id_token.required' => __('The Id Token field is required.')
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
