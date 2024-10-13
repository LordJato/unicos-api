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

   
    Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function(){
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/get', [AccountController::class, 'show'])->name('get');
        Route::post('/create', [AccountController::class, 'store'])->name('create'); 
        Route::put('/update', [AccountController::class, 'update'])->name('update');
        Route::delete('/delete', [AccountController::class, 'destroy'])->name('delete');
    });
});

