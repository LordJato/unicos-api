<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('/', [UserController::class, 'index']);
    Route::get('/get', [UserController::class, 'show']);
    Route::post('/create', [UserController::class, 'store']);
    Route::put('/update', [UserController::class, 'update']);
    Route::delete('/delete', [UserController::class, 'destroy']);
    Route::put('/update-roles', [UserController::class, 'updateRoles']);
});