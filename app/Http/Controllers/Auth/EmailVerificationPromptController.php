<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
        public function __invoke(Request $request)
    {
        // Nếu dùng Inertia, trả về view Vue/React
        return Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
        ]);
    }
}
