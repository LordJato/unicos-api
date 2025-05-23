<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AccountController;


Route::apiResource('accounts', AccountController::class);
Route::get('account-types', [AccountController::class, 'showAllAccountType']);