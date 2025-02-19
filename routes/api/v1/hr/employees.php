<?php

use App\Http\Controllers\v1\HR\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'hr', 'as' => 'hr.'], function(){
    Route::apiResource('employees', EmployeeController::class);
    Route::put('/update-roles', [EmployeeController::class, 'updateRoles']);
});