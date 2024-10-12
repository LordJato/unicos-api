<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/accounts', [AccountController::class, 'index']);
    Route::group(['prefix' => 'account', 'as' => 'account.'], function(){
        Route::get('/get', [AccountController::class, 'show']);
        Route::post('/create', [AccountController::class, 'store']); 
        Route::put('/update', [AccountController::class, 'update']);
    });
});

