<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Public

//Protected
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::resource('/categories', CategoryController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/restaurants', [RestaurantController::class, 'index']);


Route::post('/request-otp', [OTPController::class, 'requestOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);
Route::get('/otp-all', function(){
    return OTP::all();
});
