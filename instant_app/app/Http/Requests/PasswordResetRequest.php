<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|max:30',
            'password_confirmation' => 'required|min:8|max:30|same:password',
            'token' => 'required|exists:password_resets,token'
        ];
    }
}

