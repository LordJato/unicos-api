<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\UserController;


//VERSION 1 API
Route::prefix('v1')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('refresh-token', [AuthController::class, 'newAccessToken'])->name('refresh.token');

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/', [UserController::class, 'profile']);
        });

        //Users
        require_once __DIR__ . "/api/v1/users.php";

        //Accounts
        require_once __DIR__ . "/api/v1/accounts.php";

        //Companies
        require_once __DIR__ . "/api/v1/companies.php";

        //Roles
        require_once __DIR__ . "/api/v1/roles.php";

        //Permissions
        require_once __DIR__ . "/api/v1/permissions.php";

        //Links
        require_once __DIR__ . "/api/v1/links.php";

        //HR Modules
        require_once __DIR__ . '/api/v1/hr/index.php';

        //Recruitment Modules
        require_once __DIR__ . '/api/v1/recruitment/index.php';

        //Recruitment Modules
        require_once __DIR__ . '/api/v1/setup/index.php';
    });
});
