<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\AuthUserApiRequest;
use App\Http\Requests\StoreApiRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;


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
        $user = $this->userService->createUser($data);
        $token = $user->createToken('AuthToken')->accessToken;
        return response(["token" => $token], 201);
    }

    public function authUser(AuthUserApiRequest $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $user = \Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response(["token" => $token], 200);
        }
        return response(['error' => 'Wrong email or password'], 422);
    }
}
