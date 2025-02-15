<?php

use App\Http\Controllers\Recruitment\OpportunityController;
use Illuminate\Support\Facades\Route;

Route::apiResource('recruitment/opportunities', OpportunityController::class);