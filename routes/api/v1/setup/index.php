<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'setup', 'as' => 'setup.'], function () {
    //Department Routes
    require_once __DIR__ . '/departments.php';
    //Department Routes
    require_once __DIR__ . '/company_events.php';
    //Department Routes
    require_once __DIR__ . '/holidays.php';
});
