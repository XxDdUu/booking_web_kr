<?php

namespace App\Repositories;

use App\Models\Stay;
use Illuminate\Support\Collection;
use Log;

class StayRepository
{
    public function getStaysForCard(int $limit = 10): Collection
    {
        return Stay::query()
            ->with([
                'location',
                'service',
                'category'
            ])
            ->limit($limit)
            ->get();
    }
    public function getStayById(string $id): Stay
    {
        return Stay::query()
            ->with([
                'location',
                'service',
                'category',
                'reviews.user',
            ])
            ->where('stayID', $id)
            ->first();
    }
    public function updateRatingByService(string $serviceID, float $rating): void
    {
        Stay::where('serviceID', $serviceID)
        ->update(['rating' => $rating]);
    }
}
