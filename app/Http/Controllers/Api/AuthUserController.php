<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthUserController extends Controller
{
    public function me(Request $request)
    {
        $header = $request->header('Authorization');

        if (!$header) {
            return response()->json(['user' => null], 200);
        }

        $token = str_replace('Bearer ', '', $header);
        $hashedToken = hash('sha256', $token);

        $user = User::where('remember_token', $hashedToken)->first();

        if (!$user) return response()->json(['user' => null], 200);

        $user->makeHidden(['password', 'remember_token']);
        return response()->json(['user' => $user], 200);
    }
}
