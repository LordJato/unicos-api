
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\RoleController;


Route::apiResource('roles', RoleController::class);
Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
    Route::get('/with-permissions', [RoleController::class, 'rolesPermissions']);
    Route::post('/attach-permissions', [RoleController::class, 'attachPermissions']);
});
