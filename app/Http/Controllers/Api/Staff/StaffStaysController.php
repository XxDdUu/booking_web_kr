<?php

namespace App\Http\Controllers\Api\Staff;

use Illuminate\Http\Request;
use App\Services\Staff\StaffStayService;
use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Log;
class StaffStaysController extends Controller
{
    public function __construct(
        protected StaffStayService $service,
        protected TokenService $tokenService
    ) {}

    public function store(Request $request)
    {
        $token = $this->tokenService->extractToken($request->header('Authorization'));
        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        };
        $role = $user->role;

        if (!in_array($role, ['staff', 'admin'])) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }
        $validated = $request->validate([
            'locationID' => 'required|exists:locations,locationID',
            'categoryID' => 'required|exists:categories,categoryID',

            'stayName'   => 'required|string|max:128',
            'description'=> 'nullable|string',
            'address'    => 'nullable|string',

            'price'      => 'required|numeric|min:0',
            'rate'       => 'nullable|numeric|min:0|max:5',
            
            'image'      => 'nullable|array',
            'image.*'    => 'nullable|string',
        ]);
        $stay = $this->service->createStay($validated);

        return response()->json([
            'ok'   => true,
            'data' => $stay
        ], 201);
    }
}
