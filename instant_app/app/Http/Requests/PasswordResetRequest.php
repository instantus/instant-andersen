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
            'token' => 'required|exists:password_resets,token',
            'password' => 'required|min:8|max:30',
            'password_confirmation' => 'required|min:8|max:30|same:password'
        ];
    }
}

