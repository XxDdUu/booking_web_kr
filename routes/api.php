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
use Illuminate\Support\Facades\Route;

Route::post('/check_email', [AuthCheckController::class, 'checkEmail']);
Route::post('/check_phone', [AuthCheckController::class, 'checkPhone']);
Route::post('/otp/send-otp', [AuthOtpRegisterController::class, 'sendOtp']);
Route::post('/otp/verify-otp', [AuthOtpRegisterController::class, 'verifyOtp']);
Route::post('/auth/register', [AuthOtpRegisterController::class, 'register']);

Route::get('/auth/me', [AuthUserController::class, 'me']);
Route::patch('/user/avatar', [UserController::class, 'updateAvatarUrl']);
Route::post('/auth/logout', [AuthUserController::class, 'logout']);
Route::post('/auth/login', [AuthUserController::class, 'login']);


Route::post('/upload', action: [FileController::class, 'upload']);
Route::get('/image/{filename}', [FileController::class, 'get']);
Route::get('/keysearch',[LocationKeywordsController::class,'getKeywords']);
Route::get('/stays/search',[StaysResultsController::class,'searchingResults']);
Route::get('/stays/all',[StaysResultsController::class,'getAllResults']);
Route::get('/attractions/search',[AttractionsResultsController::class,'searchingResults']);
Route::get('/cars/search',[CarsResultsController::class,'searchingResults']);
Route::post('/admin/locations', [LocationController::class, 'store']);
Route::put('/admin/locations/{id}', [LocationController::class, 'put']);
Route::get('/admin/locations', [LocationController::class, 'index']);

