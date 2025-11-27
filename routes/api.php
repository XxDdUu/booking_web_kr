<?php
use App\Http\Controllers\Api\AuthCheckController;
<<<<<<< Updated upstream
use App\Http\Controllers\Api\AuthOtpRegisterController;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpRegisterController::class, 'verifyOtp']);
Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);
=======
use App\Http\Controllers\Api\AuthOtpController;
use App\Http\Controllers\StaysController;
use Illuminate\Support\Facades\Route;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpController::class, 'verifyOtp']);
Route::get('/stays/search', [StaysController::class, 'search']);
>>>>>>> Stashed changes
