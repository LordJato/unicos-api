
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::get('/get', [RoleController::class, 'show']);
    Route::post('/create', [RoleController::class, 'store']);
    Route::put('/update', [RoleController::class, 'update']);
    Route::delete('/delete', [RoleController::class, 'destroy']);
    Route::get('/permissions', [RoleController::class, 'rolesPermissions']);
    Route::post('/attach-permissions', [RoleController::class, 'attachPermissions']);
});
