<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\StoreApiRequest as StoreApiRequest;
use App\Models\User as User;


class UserController extends Controller
{
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $validator->errors()->add('field', 'Something is wrong with this field!');
        });
    }

    public function store (StoreApiRequest $request) {
        $user = new User();
        $user->fill([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);
        $user->save();
        if ($user) {
            $token = $user->createToken('AuthToken')->accessToken;
            return response(["token" => $token], 201);
        }
    }
}
