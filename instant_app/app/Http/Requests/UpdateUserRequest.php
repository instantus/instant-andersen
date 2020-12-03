<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = $this->route('user');
        return [
            'name' => 'required|min:3|max:30',
            'email' => [
                'email',
                Rule::unique('users', 'email')->ignore($user_id),
            ],
            'password' => 'min:8|max:30',
            'password_confirmation' => 'min:8|max:30|same:password',
        ];
    }
}
