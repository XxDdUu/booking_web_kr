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
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Staff\StaysController;
use App\Http\Controllers\Api\Staff\StayFormController;
use App\Http\Controllers\Api\Admin\AdminUserController;

Route::post('/auth/check-email', [AuthCheckController::class, 'checkEmail']);
Route::post('/auth/check-phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify', [AuthOtpRegisterController::class, 'verifyOtp']);

Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);
Route::get('/auth/me', [AuthUserController::class, 'me']);
Route::patch('/user/avatar', [UserController::class, 'updateAvatarUrl']);
Route::post('/auth/logout', [AuthUserController::class, 'logout']);
Route::post('/auth/login', [AuthUserController::class, 'login']);


Route::post('/upload', action: [FileController::class, 'upload']);
Route::post('/upload-multiple', [FileController::class, 'uploadMultiple']);
Route::get('/keysearch',[LocationKeywordsController::class,'getKeywords']);
Route::get('/stays/search',[StaysResultsController::class,'searchingResults']);
Route::get('/stays/all',[StaysResultsController::class,'getAllResults']);
Route::get('/attractions/search',[AttractionsResultsController::class,'searchingResults']);
Route::get('/cars/search',[CarsResultsController::class,'searchingResults']);

Route::post('/admin/locations', [LocationController::class, 'store']);
Route::put('/admin/locations/{id}', [LocationController::class, 'put']);
Route::get('/admin/locations', [LocationController::class, 'index']);
Route::get('/admin/customer-staff', [AdminUserController::class, 'getCustomerAndStaff']);

Route::post('/bookings',[BookingController::class,'store']);
route::post('/payment/confirm',[PaymentController::class,'confirm']);
Route::post('/staff/stays', [StaysController::class, 'store']);
Route::get('/staff/stay-form', [StayFormController::class, 'getFormData']);
