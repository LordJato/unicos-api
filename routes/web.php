<?php

use Illuminate\Support\Facades\Route;


Route::get('/secured/register', function ($path) {
    return response()->json(['message' => "Welcome to the secured page: {$path}"]);
})->name('secured.route')->where('path', '.*')->middleware('signed');


Route::get('/', function () {
    return view('welcome');
});
