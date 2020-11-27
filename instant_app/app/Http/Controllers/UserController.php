<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\AuthUserApiRequest;
use App\Http\Requests\StoreApiRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $userService;
    protected $token = null;

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
        $this->token = $user->createToken('AuthToken')->accessToken;
        return response(["token" => $this->token], 201);
    }

    public function authUser(AuthUserApiRequest $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        if (Auth::attempt($data)) {
            $user = User::where('email', $data['email'])->first();
            $this->token = $user->createToken('AuthToken')->accessToken;
            return response(["token" => $this->token], 201);
        }
        return response(['error' => 'Wrong email or password'], 422);
    }
}
