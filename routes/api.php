<?php

use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\ProvidersController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthOtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'home'],function($router){
    Route::get('/show',[ServicesController::class,'showHome']);
});
Route::group(['prefix'=>'services'],function($router){
    Route::get('/show',[ServicesController::class,'show']);
    Route::get('/show/{service}',[ServicesController::class,'serviceDetails']);

});
Route::group(['prefix'=>'country'],function($router){
    Route::get('/show',[LocationsController::class,'country']);
    Route::get('/locations/show',[LocationsController::class,'location']);
    Route::get('/locations/show/{location}',[LocationsController::class,'locationDetails']);

});
Route::group(['prefix'=>'providers'],function($router){
    Route::get('/show',[ProvidersController::class,'show']);
    Route::get('/show/{provider}',[ProvidersController::class,'providerDetails']);
});
Route::group(['prefix'=>'search'],function($router){
    Route::get('/{query}',[SearchController::class,'search']);
});
Route::group(['prefix'=>'gallery'],function($router){
    Route::post('/store/{provider}',[GalleryApiController::class,'store']);
    Route::get('/show/{provider}',[GalleryApiController::class,'show']);
    Route::delete('/delete/{image}',[GalleryApiController::class,'delete']);

});
Route::group(['prefix'=>'auth'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/update/profile/{id}', [AuthController::class, 'update']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //otp
    Route::Post('/otp/generate', [AuthOtpController::class, 'otpGenerate']);
    Route::Post('/otp/login', [AuthOtpController::class, 'loginWithOtp']);
    Route::Post('/otp/update/password', [AuthOtpController::class, 'updatePassword']);
});


