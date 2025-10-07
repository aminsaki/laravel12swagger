<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::apiResource('users', UserController::class);

Route::middleware('auth:api')->group(function () {

//    Route::apiResource('api/users',UserController::class);

});
