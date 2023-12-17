<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExchangeRatesController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRequestLogController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/auth')->group(function () {
    Route::get('/me', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('/exchange-rates')->group(function () {
        Route::get('/', [ExchangeRatesController::class, 'index']);
        Route::post('/calculate', [ExchangeRatesController::class, 'calculate']);
    });
});

/*
|--------------------------------------------------------------------------
| Admin authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth.admin')->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/logs', [UserRequestLogController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'user']);
            Route::get('/{id}/logs', [UserRequestLogController::class, 'getLogsByUser']);
        });
    });
});
