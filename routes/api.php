<?php

use App\Http\Controllers\Api\AttractionsResultsController;
use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpRegisterController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\CarsResultsController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\StaysController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\Search\StaySearchController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Admin\AdminLocationController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Staff\StaffStaysController;
use App\Http\Controllers\Api\Staff\StaffRoomsController;
use App\Http\Controllers\Api\Staff\StaffStayFormController;
use App\Http\Controllers\Api\Staff\StaffRoomFormController;


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
    Route::post('/review', [ReviewController::class, 'store']);
    Route::delete('/review/{reviewID}', [ReviewController::class, 'destroy']);
    Route::get('/attractions/search', [AttractionsResultsController::class, 'searchingResults']);
    Route::get('/cars/search', [CarsResultsController::class, 'searchingResults']);
});

Route::prefix('upload')->group(function () {
    Route::post('/', [FileController::class, 'upload']);
    Route::post('/multiple', [FileController::class, 'uploadMultiple']);
});

Route::prefix('stays')->group(function () {
    Route::get('/search', [StaySearchController::class, 'search']);
    Route::get('/suggest', [StaySearchController::class, 'suggest']);
    Route::get('/', [StaysController::class, 'index']);
    Route::get('{id}', [StaysController::class, 'show']);
    Route::delete( '{id}', [StaysController::class, 'destroy']);

    Route::get('/{id}/rooms', [RoomController::class, 'index']);
});

Route::get('/attractions/search', [AttractionsResultsController::class, 'searchingResults']);
Route::get('/cars/search', [CarsResultsController::class, 'searchingResults']);

Route::prefix('admin')->group(function () {
    Route::prefix('locations')->group(function () {
        Route::post('/', [AdminLocationController::class, 'store']);
        Route::put('/{id}', [AdminLocationController::class, 'put']);
        Route::get('/', [AdminLocationController::class, 'index']);
        Route::delete('/{id}', [AdminLocationController::class, 'delete']);
    });
    Route::get('/customer-staff', [AdminUserController::class, 'getCustomerAndStaff']);
});

Route::prefix('home')->group(function () {
    Route::get('locations', [LocationController::class, 'homepage']);
});

Route::prefix('staff')->group(function () {
    Route::post('/stays', [StaffStaysController::class, 'store']);
    Route::post('/rooms', [StaffRoomsController::class, 'store']);
    Route::get('/stay-form', [StaffStayFormController::class, 'getFormData']);
    Route::get('/room-form', [StaffRoomFormController::class, 'getFormData']);
});

Route::post('/bookings',[BookingController::class,'store']);
route::post('/payment/confirm',[PaymentController::class,'confirm']);
