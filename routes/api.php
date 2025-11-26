<?php

use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpRegisterController;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpRegisterController::class, 'verifyOtp']);
Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);
