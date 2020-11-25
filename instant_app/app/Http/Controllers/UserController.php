<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\StoreApiRequest as StoreApiRequest;
use App\Models\User as User;


class UserController extends Controller
{
    public function store(StoreApiRequest $request) {
        $user = new User();
        $user->fill([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);
        $user->save();
        $token = $user->createToken('AuthToken')->accessToken;
        return response(["token" => $token], 201);
    }
}
