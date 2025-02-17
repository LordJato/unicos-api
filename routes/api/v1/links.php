<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;


Route::group(['prefix' => 'links', 'as' => 'links.'], function () {
    Route::post('/register', [LinkController::class, 'registerLink']);
});
