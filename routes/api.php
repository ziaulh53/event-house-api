<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware(['role:admin'])->group(function () {
    });
    Route::middleware(['role:seller'])->group(function () {
    });
    Route::middleware(['role:buyer'])->group(function () {
    });
});

Route::post('/signup-admin', [AuthController::class, 'signup']);
Route::post('/login-admin', [AuthController::class, 'login']);
