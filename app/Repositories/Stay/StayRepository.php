<?php

namespace App\Repositories\Stay;

use App\Models\Stay;
use Illuminate\Support\Collection;
use Log;

class StayRepository implements StayRepositoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection
    {
        return Stay::query()
            ->select(['stayName', 'locationID'])
            ->where(function ($q) use ($keyword) {
                $q->where('stayName', 'LIKE', "%{$keyword}%")
                  ->orWhere('address', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('location', function ($l) use ($keyword) {
                    $l->where('locationName', 'LIKE', "%{$keyword}%");
                });
            })
            ->with([
                'location:locationID,locationName,country'
            ])
            ->limit($limit)
            ->get();
    }
    public function findByLocationName(?string $location): Collection
    {
        return Stay::query()
            ->with('location')
            ->select([
                'stayID',
                'stayName',
                'locationID',
                'address',
                'rating',
                'price',
                'image',
            ])
            ->when($location, function ($query, $location) {
                $query->whereHas('location', function ($q) use ($location) {
                    $q->where('locationName', 'LIKE', "%{$location}%");
                });
            })
            ->get();
    }
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
