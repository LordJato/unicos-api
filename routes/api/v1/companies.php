<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\CompanyController;


Route::apiResource('companies', CompanyController::class);

// Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
//     Route::get('/', [CompanyController::class, 'index']);
//     Route::get('/get', [CompanyController::class, 'show']);
//     Route::post('/create', [CompanyController::class, 'store']);
//     Route::put('/update', [CompanyController::class, 'update']);
//     Route::delete('/delete', [CompanyController::class, 'destroy']);
// });
