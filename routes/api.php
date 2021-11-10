<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\LevelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::post('/tes', [AuthController::class, 'tes']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [AuthController::class, 'getProfile']);

    Route::prefix('/attendance')->group(function () {
        Route::post('/check-in', [AttendanceController::class, 'checkIn']);
        Route::post('/check-out', [AttendanceController::class, 'checkOut']);
        Route::post('/report', [AttendanceController::class, 'report']);
    });

    Route::prefix('/employee')->group(function () {
        Route::get('/get', [EmployeeController::class, 'get']);
        Route::post('/create', [EmployeeController::class, 'create']);
        Route::post('/update', [EmployeeController::class, 'update']);
        Route::post('/delete', [EmployeeController::class, 'delete']);
    });

    Route::prefix('/division')->group(function () {
        Route::get('/get', [DivisionController::class, 'get']);
        Route::post('/create', [DivisionController::class, 'create']);
        Route::post('/update', [DivisionController::class, 'update']);
        Route::post('/delete', [DivisionController::class, 'delete']);
    });

    Route::prefix('/level')->group(function () {
        Route::get('/get', [LevelController::class, 'get']);
        Route::post('/create', [LevelController::class, 'create']);
        Route::post('/update', [LevelController::class, 'update']);
        Route::post('/delete', [LevelController::class, 'delete']);
    });
});
