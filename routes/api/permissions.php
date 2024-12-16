
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/get', [PermissionController::class, 'show']);
    Route::post('/create', [PermissionController::class, 'store']);
    Route::put('/update', [PermissionController::class, 'update']);
    Route::delete('/delete', [PermissionController::class, 'destroy']);
});
