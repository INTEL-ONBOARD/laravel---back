<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'contact' => 'nullable|string|max:15',
            'bio' => 'nullable|string',
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'captcha' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, and one number.',
        ];
    }
}
