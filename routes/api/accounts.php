<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;


Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/get', [AccountController::class, 'show']);
    Route::post('/create', [AccountController::class, 'store']);
    Route::put('/update', [AccountController::class, 'update']);
    Route::delete('/delete', [AccountController::class, 'destroy']);
});
