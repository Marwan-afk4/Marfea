<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'exists:users,id',
            'name' => 'required',
            'phone' => 'required',
            'image' => 'required',
            'location_link' => 'required',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'site_link' => 'required',
            'facebook_link' => 'required',
            'twitter_link' => 'required',
            'linkedin_link' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => __('The selected User is invalid.'),
            'name.required' => __('The Name field is required.'),
            'phone.required' => __('The Phone field is required.'),
            'image.required' => __('The Image field is required.'),
            'location_link.required' => __('The Location Link field is required.'),
            'description.required' => __('The Description field is required.'),
            'description.string' => __('The Description must be a string.'),
            'start_date.required' => __('The Start Date field is required.'),
            'start_date.date' => __('The Start Date must be a valid date.'),
            'end_date.required' => __('The End Date field is required.'),
            'end_date.date' => __('The End Date must be a valid date.'),
            'site_link.required' => __('The Site Link field is required.'),
            'facebook_link.required' => __('The Facebook Link field is required.'),
            'twitter_link.required' => __('The Twitter Link field is required.'),
            'linkedin_link.required' => __('The Linkedin Link field is required.'),
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
