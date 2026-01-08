<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService,
        protected TokenService $tokenService
    ) {}

    public function store(Request $request)
    {
        $token = $this->tokenService->extractToken($request->header('Authorization'));
        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        };

        $userID = $user->id;

        $validated = $request->validate([
            'serviceID' => 'required|string|exists:stays,serviceID',
            'rating'    => 'required|integer|min:1|max:5',
            'review'    => 'nullable|string',
        ]);

        $review = $this->reviewService->createReview([
            'userID'    => $userID,
            'serviceID' => $validated['serviceID'],
            'rating'    => $validated['rating'],
            'review'    => $validated['review'] ?? null,
        ]);

        return response()->json([
            'message' => 'Review added successfully',
            'data'    => $review
        ], 201);
    }
    public function destroy(Request $request, string $reviewID)
    {
        $token = $this->tokenService->extractToken(
            $request->header('Authorization')
        );

        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $deleted = $this->reviewService->deleteReview($reviewID, $user->id);

        if (!$deleted) {
            return response()->json([
                'message' => 'Review not found or permission denied'
            ], 403);
        }

        return response()->json([
            'message' => 'Review deleted successfully'
        ], 200);
    }
}
