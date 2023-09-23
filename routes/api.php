<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminPasswordResetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UserPasswordResetController;
use App\Http\Controllers\TestEmailController;
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
    // admin auth routers
    Route::post('/admin/logout', [AdminAuthController::class, 'adminLogout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware(['role:super_admin'])->group(function () {
        Route::apiResource('/admins', AdminController::class);
        Route::post('/category', [CategoryController::class, 'store']);
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    });

    // user auth routers
    Route::post('/logout', [UserAuthController::class, 'userLogout']);


    // both auth routers
    Route::post('/file-upload', [FileUploadController::class, 'storeUploads']);
    Route::get('/category', [CategoryController::class, 'index']);
 
    Route::middleware(['role:seller'])->group(function () {
    });
    Route::middleware(['role:buyer'])->group(function () {
    });
});



// admin route
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin']);
Route::post('/admin/forgot-password', [AdminPasswordResetController::class, 'forgotPassword'])->name('password.email');
Route::post('/admin/reset-password', [AdminPasswordResetController::class, 'resetPassword'])->name('password.reset');


//user route
Route::post('/signup', [UserAuthController::class, 'userSignup']);
Route::post('/login', [UserAuthController::class, 'userLogin']);
Route::post('/forgot-password', [UserPasswordResetController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [UserPasswordResetController::class, 'resetPassword'])->name('password.reset');
