<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\AuthUserApiRequest;
use App\Http\Requests\PasswordForgotRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\StoreApiRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


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

    public function passwordForgot(PasswordForgotRequest $request) {
        $email = $request['email'];
        $user = User::where('email', $email)->first();
        $reset = PasswordReset::where('email', $email)->first();
        if ($reset && $reset->created_at->copy()->addSeconds(2)->isPast()) {
            $reset->delete();
            $reset = false;
        }
        if (!$reset) {
            $token = md5($user->id.time());
            $reset = new PasswordReset();
            $reset->fill([
                'user_id' => $user->id,
                'email' => $email,
                'token' => $token
            ]);
            $reset->save();
            Mail::to($email)->send(new \App\Mail\PasswordReset($token));
            return response(['response' => 'Check your email to get password reset instructions'], 200);
        }
        return response(['response' => 'Email with instructions has been sent already'], 200);
    }

    public function passwordReset(PasswordResetRequest $request) {
        $token = $request['token'];
        $reset = PasswordReset::where('token', $token)->first();
        if ($reset->created_at->copy()->addHours(2)->isPast()) {
            $reset->delete();
            return response(['response' => 'Token has expired, please use "Forgot Password" again'], 200);
        }
        $user = User::findOrFail($reset->user_id);
        $user->password = bcrypt($request['password']);
        $user->save();
        $reset->delete();
        return response(['response' => 'Password was successfully changed'], 200);
    }
}
