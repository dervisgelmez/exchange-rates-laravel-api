<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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
    Route::get('me', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

});

/*
|--------------------------------------------------------------------------
| Admin authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth.admin')->group(function () {

});
