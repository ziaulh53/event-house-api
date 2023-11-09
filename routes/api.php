<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminPasswordResetController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UserPasswordResetController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    // admin auth routers
    Route::post('/admin/logout', [AdminAuthController::class, 'adminLogout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::apiResource('/users', UsersController::class);
        Route::apiResource('/admins', AdminController::class);
        Route::post('/category', [CategoryController::class, 'store']);
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
        Route::post('/banner', [BannerController::class, 'createBanner']);
    });

    // user auth routers
    Route::middleware(['role:seller,buyer'])->group(function () {
        Route::put('/update-profile/{id}', [UserAuthController::class, 'userUpdate']);
        Route::put('/update-email/{id}', [UserAuthController::class, 'userUpdateEmail']);
        Route::put('/update-password/{id}', [UserAuthController::class, 'userUpdatePassword']);
        Route::post('/logout', [UserAuthController::class, 'userLogout']);
    });


    // for all users and admin auth routers
    Route::post('/file-upload', [FileUploadController::class, 'storeUploads']);
    Route::get('/category', [CategoryController::class, 'index']);

    Route::middleware(['role:seller'])->group(function () {
        Route::post('/service', [ServiceController::class, 'createService']);
        Route::get('/my-service', [ServiceController::class, 'getUserService']);
        Route::put('/my-service/{id}', [ServiceController::class, 'updateMyService']);
        Route::delete('/my-service/{id}', [ServiceController::class, 'deleteMyService']);
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


// public route
Route::get('/service', [ServiceController::class, 'fetchServices']);
Route::get('/banner', [BannerController::class, 'fetchBanners']);
