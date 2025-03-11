<?php

use App\Http\Controllers\v1\Setup\CompanyEventController;
use Illuminate\Support\Facades\Route;

Route::apiResource('company-events', CompanyEventController::class);
