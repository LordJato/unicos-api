<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/get', [UserController::class, 'show']);
        Route::post('/create', [UserController::class, 'store']);
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete', [UserController::class, 'destroy']);
    });
   
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function(){
        Route::get('/', [AccountController::class, 'index']);
        Route::get('/get', [AccountController::class, 'show']);
        Route::post('/create', [AccountController::class, 'store']);
        Route::put('/update', [AccountController::class, 'update']);
        Route::delete('/delete', [AccountController::class, 'destroy']);
    });

    Route::group(['prefix' => 'companies', 'as' => 'companies.'], function(){
        Route::get('/', [CompanyController::class, 'index']);
        Route::get('/get', [CompanyController::class, 'show']);
        Route::post('/create', [CompanyController::class, 'store']);
        Route::put('/update', [CompanyController::class, 'update']);
        Route::delete('/delete', [CompanyController::class, 'destroy']);
    });

});

