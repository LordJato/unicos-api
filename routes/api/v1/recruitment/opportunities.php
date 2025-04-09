<?php

use App\Http\Controllers\v1\Recruitment\Opportunity\BenefitController;
use App\Http\Controllers\v1\Recruitment\Opportunity\RequirementController;
use App\Http\Controllers\v1\Recruitment\Opportunity\ResponsibilityController;
use App\Http\Controllers\v1\Recruitment\OpportunityController;
use Illuminate\Support\Facades\Route;



Route::apiResource('opportunities', OpportunityController::class);

Route::prefix('opportunities')->group(function () {
    
    Route::prefix('{opportunity}')->group(function () {

        Route::apiResource('benefits', BenefitController::class);
        
        Route::apiResource('requirements', RequirementController::class);

        Route::apiResource('resonsibilites', ResponsibilityController::class);
    });
});