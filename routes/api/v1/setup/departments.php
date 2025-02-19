<?php

use App\Http\Controllers\v1\Setup\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('departments', DepartmentController::class);

Route::group(['prefix' => 'departments', 'as' => 'departments.'], function(){
    //
});