<?php

use App\Http\Controllers\HR\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/get', [EmployeeController::class, 'show']);
    Route::post('/create', [EmployeeController::class, 'store']);
    Route::put('/update', [EmployeeController::class, 'update']);
    Route::delete('/delete', [EmployeeController::class, 'destroy']);
    Route::put('/update-roles', [EmployeeController::class, 'updateRoles']);
});