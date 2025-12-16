<?php

use App\Http\Controllers\Api\AttractionsResultsController;
use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpRegisterController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\CarsResultsController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\LocationKeywordsController;
use App\Http\Controllers\Api\StaysResultsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Admin\AdminLocationController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PaymentController as ControllersPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Staff\StaffStaysController;
use App\Http\Controllers\Api\Staff\StaffStayFormController;
use App\Http\Controllers\Api\Admin\AdminUserController;

Route::prefix('auth')->group(function () {
    Route::post('/check-email', [AuthCheckController::class, 'checkEmail']);
    Route::post('/check-phone', [AuthCheckController::class, 'checkPhone']);

    Route::post('/login', [AuthUserController::class, 'login']);
    Route::post('/logout', [AuthUserController::class, 'logout']);
    Route::get('/me', [AuthUserController::class, 'me']);

    Route::post('/register', [AuthOtpRegisterController::class, 'register']);

    Route::prefix('otp')->group(function () {
        Route::post('/send', [AuthOtpRegisterController::class, 'sendOtp']);
        Route::post('/verify', [AuthOtpRegisterController::class, 'verifyOtp']);
    });
});

Route::prefix('user')->group(function () {
    Route::patch('/avatar', [UserController::class, 'updateAvatarUrl']);
});

Route::prefix('upload')->group(function () {
    Route::post('/', [FileController::class, 'upload']);
    Route::post('/multiple', [FileController::class, 'uploadMultiple']);
});

Route::get('/keywords', [LocationKeywordsController::class, 'getKeywords']);

Route::prefix('stays')->group(function () {
    Route::get('/search', [StaysResultsController::class, 'searchingResults']);
    Route::get('/all', [StaysResultsController::class, 'getAllResults']);
});

Route::get('/attractions/search', [AttractionsResultsController::class, 'searchingResults']);
Route::get('/cars/search', [CarsResultsController::class, 'searchingResults']);


Route::prefix('admin')->group(function () {
    Route::prefix('locations')->group(function () {
        Route::post('/', [AdminLocationController::class, 'store']);
        Route::put('/{id}', [AdminLocationController::class, 'put']);
        Route::get('/', [AdminLocationController::class, 'index']);
    });

    Route::get('/customer-staff', [AdminUserController::class, 'getCustomerAndStaff']);
});


Route::prefix('staff')->group(function () {
    Route::post('/stays', [StaffStaysController::class, 'store']);
    Route::get('/stay-form', [StaffStayFormController::class, 'getFormData']);
});

Route::post('/bookings',[BookingController::class,'store']);
route::post('/payment/confirm',[ControllersPaymentController::class,'confirm']);

