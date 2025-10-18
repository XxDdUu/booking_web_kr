<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/verify-email', EmailVerificationPromptController::class)
    ->middleware(['auth'])
    ->name('verification.notice');

Route::get('/test_s3', function ()  {
    try {
        $path = 'test_s3_' .time(). '.txt';
        Storage::disk('s3')->put($path, 'This is a test file');
        return 'S3 Test: File uploaded successfully {$path}';
    } catch (Exception $e) {
        return 'S3 Test: Error - ' . $e->getMessage();
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
