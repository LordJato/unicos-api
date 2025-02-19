
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PermissionController;

Route::apiResource('permissions', PermissionController::class);

Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
//
});
