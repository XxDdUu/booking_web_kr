<?php

namespace App\Http\Controllers\Api\Staff;

use Illuminate\Http\Request;
use App\Services\Staff\StayService;
use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Illuminate\Support\Facades\Log;
// use Log;
class StaysController extends Controller
{
    public function __construct(
        protected StayService $service,
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
        Log::info($request->all());
        $validated = $request->validate([
            'locationID' => 'required|exists:locations,locationID',
            'serviceID'  => 'required|exists:services,serviceID',
            'categoryID' => 'required|exists:categories,categoryID',

            'stayName'   => 'required|string|max:128',
            'description'=> 'nullable|string',
            'location'   => 'nullable|string',
            'address'    => 'nullable|string',

            'price'      => 'required|numeric|min:0',
            'rate'       => 'nullable|numeric|min:0|max:5',

            // 👇 multiple images
            'image'      => 'nullable|array',
            'image.*'    => 'nullable|string',
        ]);
        Log::info($validated);

        $stay = $this->service->createStay($validated);

        return response()->json([
            'ok'   => true,
            'data' => $stay
        ], 201);
    }
}
