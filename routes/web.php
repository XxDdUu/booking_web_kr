<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

Route::get('/', function () {
        return response()->json([
        'message' => 'Laravel API running',
        'status' => 'OK' 
    ]);
});
Route::get('/verify-email', EmailVerificationPromptController::class)
    ->middleware(['auth'])
    ->name('verification.notice');

Route::get('/test_s3', function ()  {
    try {
        $path = 'test_s3_' .time(). '.txt';
        Storage::disk('s3')->put($path, 'This is a test file');
        $url = Storage::disk('s3')->url($path);
        return "S3 Test: File uploaded successfully <br>URL: <a href='{$url}' target='_blank'>{$url}</a>";;
    } catch (Exception $e) {
        return 'S3 Test: Error - ' . $e->getMessage();
    }
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
