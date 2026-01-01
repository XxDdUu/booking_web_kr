<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use Illuminate\Support\Collection;

class LocationService
{
    public function __construct(
        protected LocationRepository $locationRepository
    ) {} 

    public function getHomepageLocations(): Collection
    {
        return $this->locationRepository->getHomepageLocations(5);
    }
}
