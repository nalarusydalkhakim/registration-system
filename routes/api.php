<?php

use App\Http\Controllers\API\Admin\CourseController;
use App\Http\Controllers\API\Admin\DepartmentController;
use App\Http\Controllers\API\Admin\DepartmentRequirementController;
use App\Http\Controllers\API\Admin\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AccountController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('request-reset-password', [AuthController::class, 'requestPasswordReset']);
    Route::post('reset-password', [AuthController::class, 'passwordReset']);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('me', [AccountController::class, 'me']);
        Route::post('update-account', [AccountController::class, 'updateAccount']);
        Route::post('update-password', [AccountController::class, 'updatePassword']);
        Route::post('request-new-verify-email', [AccountController::class, 'requestNewVerifyEmail']);
        Route::post('verify-email', [AccountController::class, 'verifyEmail']);
        Route::post('logout', [AccountController::class, 'logout']);
    });
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('permissions', [RoleController::class, 'getPermission']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('departments', DepartmentController::class)->except(['create', 'edit']);
    Route::apiResource('courses', CourseController::class)->except(['create', 'edit']);
    Route::apiResource('department-requirements', DepartmentRequirementController::class)->except(['create', 'edit']);
    Route::apiResource('registrations', RegistrationController::class)->except(['create', 'edit']);
});