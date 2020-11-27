<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public $token;

    public function createUser(array $data) {
        $user = new User();
        $user->fill([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password'])
        ]);
        $user->save();
        $this->token = $user->createToken('AuthToken')->accessToken;
        return $user;
    }

    public function getUser(array $data) {
        if (Auth::attempt($data)) {
            $user = User::where('email', $data['email'])->first();
            $this->token = $user->createToken('AuthToken')->accessToken;
            return $user;
        }
        return null;
    }
}
