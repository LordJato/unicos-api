<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'hr', 'as' => 'hr.'], function () {
    //Employees Routes
    require_once __DIR__ . '/employees.php';
});
