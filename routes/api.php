<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('update/profile', [AuthController::class, 'updateProfile']);
    Route::get('profile', [AuthController::class, 'getProfile']);
    Route::delete('user/delete', [AuthController::class, 'deleteUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('home', [HomeController::class, 'Home']);
Route::get('allProviders', [HomeController::class, 'allProviders']);
Route::get('allServices', [HomeController::class, 'allServices']);




