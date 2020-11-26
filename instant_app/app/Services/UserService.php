<?php


namespace App\Services;


use App\Models\User;

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
}
