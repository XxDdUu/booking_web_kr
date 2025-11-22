<?php

use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpController;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpController::class, 'verifyOtp']);
