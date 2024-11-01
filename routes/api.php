<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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
    

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('profile', [UserController::class, 'profile']);
    });

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

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function(){
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/get', [RoleController::class, 'show']);
        Route::post('/create', [RoleController::class, 'store']);
        Route::put('/update', [RoleController::class, 'update']);
        Route::delete('/delete', [RoleController::class, 'destroy']);
        Route::get('/permissions', [RoleController::class, 'rolesPermissions']);
        Route::post('/attach-permissions', [RoleController::class, 'attachPermissions']);
    });

    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function(){
        Route::get('/', [PermissionController::class, 'index']);
        Route::get('/get', [PermissionController::class, 'show']);
        Route::post('/create', [PermissionController::class, 'store']);
        Route::put('/update', [PermissionController::class, 'update']);
        Route::delete('/delete', [PermissionController::class, 'destroy']);
    });

});

