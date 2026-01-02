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

    public function getLocationKeyWords(int $limit = 10, ?string $keyword): Collection
    {
        return Location::query()
            ->select([
                'locationID',
                'locationName'
            ])
            ->when($keyword, function($query) use ($keyword){
                $search = '%'.Str::lower($keyword).'%';
                $query->where('locationName', 'LIKE', $search);
            })
            ->limit($limit)
            ->get();
    }
}
