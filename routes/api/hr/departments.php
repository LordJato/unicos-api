<?php

use App\Http\Controllers\Setting\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'departments', 'as' => 'departments.'], function(){
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/get', [DepartmentController::class, 'show']);
    Route::post('/create', [DepartmentController::class, 'store']);
    Route::put('/update', [DepartmentController::class, 'update']);
    Route::delete('/delete', [DepartmentController::class, 'destroy']);
});