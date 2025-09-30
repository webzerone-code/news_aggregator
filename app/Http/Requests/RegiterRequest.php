<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegiterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed:c_password',
            'c_password' => 'required|same:password'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'name is required',
            'name.string'    => 'name must be string',
            'name.max'       => 'name is too long',
            'email.required' => 'email field is required.',
            'email.unique'   => 'This email is already registered. Please log in instead.',
            'password.required' => 'password is required',
            'password.min'   => 'Your password must be at least 8 characters long for security.',
            'c_password.required' => 'Confirm password is required.',
        ];
    }
}
