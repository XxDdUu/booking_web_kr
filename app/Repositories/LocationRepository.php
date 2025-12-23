<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Support\Collection;

class LocationRepository
{
    public function searchNamesByKeyword(string $keyword, int $limit = 10): Collection
    {
        return Location::nameLikeBinary($keyword)
            ->limit($limit)
            ->pluck('locationName');
    }
    public function getHomepageLocations(
        int $limit = 5
    ): Collection {
        return Location::query()
            ->select([
                'locationID',
                'locationName',
                'location_image_path',
            ])
            ->limit($limit)
            ->get();
    }
}
