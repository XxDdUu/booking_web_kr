<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Laravel\Sanctum\HasApiTokens;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
        'password' => 'required|string',
        'email' => 'required_without:phone|email',
        'phone' => 'required_without:email|string',
        'remember' => 'boolean'
    ]);
}
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
