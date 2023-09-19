<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FileUploadController;
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
    Route::post('/admin/logout', [AdminAuthController::class, 'adminLogout']);


    Route::post('/file-upload', [FileUploadController::class, 'storeUploads']);

    Route::middleware(['role:super_admin'])->group(function () {
        // Route::post('/admin/signup', [AdminAuthController::class, 'adminSignup']);
        Route::apiResource('/admins', AdminController::class);
    });
    Route::middleware(['role:seller'])->group(function () {
    });
    Route::middleware(['role:buyer'])->group(function () {
    });
});



// admin route
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin']);

//user route
Route::post('/signup', [AuthController::class, 'userSignup']);
Route::post('/login', [AuthController::class, 'userLogin']);
