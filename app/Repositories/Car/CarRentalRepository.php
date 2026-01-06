<?php

namespace App\Repositories\Car;

use App\Models\CarRental;
use App\Repositories\Car\CarRentalRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Collection;
use Log;

class CarRentalRepository implements CarRentalRepositoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection
    {
        return CarRental::query()
            ->select(['carRentalID','carID', 'locationID'])
            ->where(function ($q) use ($keyword) {
                $q->where('carName', 'LIKE', "%{$keyword}%")
                  ->orWhere('checkInDestination', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('location', function ($l) use ($keyword) {
                    $l->where('locationName', 'LIKE', "%{$keyword}%");
                });
            })
            ->with([
                'location:locationID,locationName,country',
                'car:carID,carName'
            ])
            ->limit($limit)
            ->get();
    }
    public function queryByLocationName(?string $location): Builder
    {
        return CarRental::query()
            ->with('location')
            ->select([
                'carID',
                'carName',
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

    public function getCarsForCard(int $limit = 10): Collection
    {
        return CarRental::query()
            ->with([
                'location',
                'service',
                'car'
            ])
            ->limit($limit)
            ->get();
    }
    public function getCarRentalById(string $id): CarRental
    {
        return CarRental::query()
            ->with([
                'location',
                'service',
                'car',
                'reviews.user',
            ])
            ->where('CarRentalID', $id)
            ->first();
    }
    public function updateRatingByService(string $serviceID, float $rating): void
    {
        CarRental::where('serviceID', $serviceID)
        ->update(['rate' => $rating]);
    }
}