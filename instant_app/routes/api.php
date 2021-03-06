<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController as UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', [UserController::class, 'store']);
Route::middleware('auth:api')->get('/users/{user}', [UserController::class, 'show']);
Route::middleware('auth:api')->get('/users/', [UserController::class, 'index']);
Route::middleware('auth:api')->put('/users/{user}', [UserController::class, 'updateUser']);
Route::middleware('auth:api')->delete('/users/{user}', [UserController::class, 'deleteUser']);

Route::post('/auth', [UserController::class, 'authUser']);

Route::post('/forgot', [UserController::class, 'passwordForgot']);
Route::post('/reset', [UserController::class, 'passwordReset']);
