<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    public function create(array $data)
    {
        return Review::create($data);
    }
    public function getAverageRatingByService(string $serviceID): ?float
    {
        return Review::where('serviceID', $serviceID)
            ->avg('rating');
    }
    public function delete(string $reviewID, string $userID) {
        $review = Review::where('reviewID', $reviewID)
            ->where('userID', $userID)
            ->first();

        if (!$review) return false;

        $review->delete();
        return true;
    }
}