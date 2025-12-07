<?php
use App\Http\Controllers\Api\AuthCheckController;
use App\Http\Controllers\Api\AuthOtpRegisterController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\LocationKeywordsController;
use App\Http\Controllers\Api\StaysResultsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpRegisterController::class, 'verifyOtp']);
Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);

Route::get('/auth/me', [AuthUserController::class, 'me']);
Route::patch('/user/avatar', [UserController::class, 'updateAvatarUrl']);



Route::post('/upload', action: [FileController::class, 'upload']);
Route::get('/image/{filename}', [FileController::class, 'get']);
Route::get('/stays/keysearch',[LocationKeywordsController::class,'getKeywords']);
Route::get('/stays/search',[StaysResultsController::class,'searchingResult']);
Route::get('/stays/all',[StaysResultsController::class,'getAllResults']);
