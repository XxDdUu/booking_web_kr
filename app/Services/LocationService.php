<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class LocationService
{
    public function __construct(
        protected LocationRepository $locationRepository
    ) {}

    public function getHomepageLocations(): Collection
    {
        return $this->locationRepository->getHomepageLocations(5);
    }

    public function getLocationKeyWord(string $keyword): Collection
    {
        return $this->locationRepository->getLocationKeyWords(
            10,
            $keyword
        );
    }
}
