<?php

use App\Http\Controllers\HR\OpportunityController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'hr/opportunities', 'as' => 'hr.opportunities.'], function(){
    Route::get('/', [OpportunityController::class, 'index']);
    Route::get('/get', [OpportunityController::class, 'show']);
    Route::post('/create', [OpportunityController::class, 'store']);
    Route::put('/update', [OpportunityController::class, 'update']);
    Route::delete('/delete', [OpportunityController::class, 'destroy']);
    Route::put('/update-roles', [OpportunityController::class, 'updateRoles']);
});