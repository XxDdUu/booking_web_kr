<?php
use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpRegisterController;
use App\Http\Controllers\Api\LocationKeywordsController;
use App\Http\Controllers\Api\StayResultSearchController;
use Illuminate\Support\Facades\Route;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpRegisterController::class, 'verifyOtp']);
Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);
Route::get('/stays/keysearch',[LocationKeywordsController::class,'getKeywords']);
Route::get('/stays/staysResults',[StayResultSearchController::class,'searchingResult']);
