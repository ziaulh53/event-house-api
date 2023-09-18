<?php

use App\Http\Controllers\Api\AdminAuthController;
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

// admin route
Route::post('/signup-admin', [AdminAuthController::class, 'adminSignup']);
Route::post('/login-admin', [AdminAuthController::class, 'adminLogin']);

//user route
Route::post('/signup', [AuthController::class, 'userSignup']);
Route::post('/login', [AuthController::class, 'userLogin']);
