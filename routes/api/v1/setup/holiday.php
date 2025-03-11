<?php

use App\Http\Controllers\v1\Setup\HolidayController;
use Illuminate\Support\Facades\Route;

Route::apiResource('holidays', HolidayController::class);
