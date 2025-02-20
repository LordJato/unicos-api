<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'recruitment', 'as' => 'recruitment.'], function () {
    
    //Opportunity Routes
    require_once __DIR__ . '/opportunities.php';
});
