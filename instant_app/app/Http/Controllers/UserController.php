<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserApiRequest;
use App\Http\Requests\StoreApiRequest;
use App\Services\UserService;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(StoreApiRequest $request) {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];
        $this->userService->createUser($data);
        return response(["token" => $this->userService->token], 201);
    }

    public function getUser(GetUserApiRequest $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $this->userService->getUser($data);
        $token = $this->userService->token;
        if (is_null($token)) {
            return response(['error' => 'Wrong email or password'], 422);
        }
        return response(["token" => $token], 201);

    }
}
