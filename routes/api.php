<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('refresh-token', [AuthController::class, 'newAccessToken'])->name('refresh.token');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('profile', [UserController::class, 'profile']);
    });

     //Links
     require __DIR__ . "/api/links.php";

    //Users
    require __DIR__ . "/api/users.php";

    //Accounts
    require __DIR__ . "/api/accounts.php";

    //Companies
    require __DIR__ . "/api/companies.php";

    //Roles
    require __DIR__ . "/api/roles.php";

    //Permissions
    require __DIR__ . "/api/permissions.php";

    //Departments
    require __DIR__ . "/api/hr/departments.php";

    //Employees
    require __DIR__ . "/api/hr/employees.php";

     //Opportunities
     require __DIR__ . "/api/recruitment/opportunities.php";
});
