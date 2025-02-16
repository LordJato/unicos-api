<?php

use App\Http\Controllers\Setup\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class);

Route::group(['prefix' => 'departments', 'as' => 'departments.'], function(){
    //
});