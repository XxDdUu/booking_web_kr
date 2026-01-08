<?php

namespace App\Repositories\Attraction;

use App\Models\Attraction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AttractionRepository implements AttractionReporsitoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection
    {
        return Attraction::query()
            ->select(['attractionID','attractionName', 'categoryID', 'locationID'])
            ->where(function ($q) use ($keyword) {
                $q->where('attractionName', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('category',function($cate) use ($keyword){
                        $cate->where('categoryName','LIKE',"%{$keyword}%");
                    })
                    ->orWhereHas('location', function ($l) use ($keyword) {
                        $l->where('locationName', 'LIKE', "%{$keyword}%");
                    });
            })
            ->with([
                'location:locationID,locationName,country',
                'category:categoryID,categoryName'
            ])
            ->limit($limit)
            ->get();
    }
    public function queryByLocationName(?string $location): Builder
    {
        return Attraction::query()
            ->with('location')
            ->select([
                'attractionID',
                'attractionName',
                'locationID',
                'rate',
                'price',
            ])
            ->when($location, function ($query, $location) {
                $query->whereHas('location', function ($q) use ($location) {
                    $q->where('locationName', 'LIKE', "%{$location}%");
                });
            });
    }

    public function getAttractionsForCard(int $limit = 10): Collection
    {
        return Attraction::query()
            ->with([
                'location',
                'service',
                'category'
            ])
            ->limit($limit)
            ->get();
    }
    public function getAttractionById(string $id): Attraction
    {
        return Attraction::query()
            ->with([
                'location',
                'service',
                'category',
                'reviews.user',
            ])
            ->where('attractionID', $id)
            ->first();
    }
    public function updateRatingByService(string $serviceID, float $rating): void
    {
        Attraction::where('serviceID', $serviceID)
            ->update(['rate' => $rating]);
    }
}
