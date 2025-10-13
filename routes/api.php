<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;

Route::post('/register', [RegisterUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);