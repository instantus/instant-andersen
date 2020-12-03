<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser(array $data) {
        $user = new User();
        $user->fill([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password'])
        ]);
        $user->save();
        return $user;
    }

    public function updateUser(array $data, $user) {
        $update = [];
        if (!is_null($data['name'])) {
            $update['name'] = $data['name'];
        }
        if (!is_null($data['email'])) {
            $update['email'] = $data['email'];
        }
        if (!is_null($data['password'])) {
            $update['password'] = bcrypt($data['password']);
        }

        if (count($update) != 0) {
            $user->fill($update);
            $user->save();
            return ['Message' => 'Profile updated'];
        }
        return ['Message' => 'Nothing to update'];
    }
}
