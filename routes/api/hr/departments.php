<?php

use App\Http\Controllers\Setting\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'departments', 'as' => 'departments.'], function(){
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'destroy']);
});