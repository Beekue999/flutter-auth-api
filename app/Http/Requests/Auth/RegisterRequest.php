<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Name is required.',
            'name.string'             => 'Name must be a string.',
            'name.max'                => 'Name must not exceed 255 characters.',
            'email.required'          => 'Email is required.',
            'email.email'             => 'Email must be a valid email address.',
            'email.unique'            => 'This email is already registered.',
            'password.required'       => 'Password is required.',
            'password.string'         => 'Password must be a string.',
            'password.min'            => 'Password must be at least 8 characters.',
            'password.confirmed'      => 'Password confirmation does not match.',
        ];
    }
}
