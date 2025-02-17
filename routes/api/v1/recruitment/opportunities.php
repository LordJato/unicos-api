<?php

use App\Http\Controllers\Recruitment\OpportunityController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'recruitment', 'as' => 'recruitment.'], function(){
    Route::apiResource('opportunities', OpportunityController::class);
});