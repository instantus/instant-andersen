<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetUserApiRequest extends FormRequest
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
        ];
    }
}
