<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::apiResource('users', UserController::class);
Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::put('/update-roles', [UserController::class, 'updateRoles']);
});