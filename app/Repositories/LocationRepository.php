<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LocationRepository
{
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
