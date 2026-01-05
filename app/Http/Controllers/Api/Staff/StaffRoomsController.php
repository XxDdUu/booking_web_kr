<?php

namespace App\Http\Controllers\Api\Staff;

use Illuminate\Http\Request;
use App\Services\Staff\StaffRoomService;
use App\Http\Controllers\Controller;
use App\Services\TokenService;
use Log;
class StaffRoomsController extends Controller
{
    public function __construct(
        protected StaffRoomService $service,
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
            'stayID' => 'required|exists:stays,stayID',
            'roomTypeID' => 'required|exists:roomTypes,roomTypeID',

            'roomName'   => 'required|string|max:128',
            'description'=> 'nullable|string',
            'quantity'    => 'required|numeric|min:1',

            'price'      => 'required|numeric|min:0',
            'rate'       => 'nullable|numeric|min:0|max:5',
            
            'image'      => 'nullable|array',
            'image.*'    => 'nullable|string',
        ]);
        $room = $this->service->createRoom($validated['stayID'], $validated);

        return response()->json([
            'ok'   => true,
            'data' => $room
        ], 201);
    }
}
