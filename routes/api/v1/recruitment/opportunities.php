<?php

use App\Http\Controllers\v1\Recruitment\OpportunityController;
use Illuminate\Support\Facades\Route;



Route::apiResource('opportunities', OpportunityController::class);
