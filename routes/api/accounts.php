<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;


Route::apiResource('accounts', AccountController::class);
