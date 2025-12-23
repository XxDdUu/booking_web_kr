<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use Illuminate\Support\Collection;

class LocationService
{
    public function __construct(
        protected LocationRepository $locationRepository
    ) {} 

    public function searchLocationKeywords(string $q): Collection
    {
        if (strlen($q) < 2) {
            return collect();
        }

        return $this->locationRepository
            ->searchNamesByKeyword($q);
    }
    public function getHomepageLocations(): Collection
    {
        return $this->locationRepository->getHomepageLocations(5);
    }
}
