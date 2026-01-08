<?php

namespace App\Services\Search;

use App\Repositories\Attraction\AttractionRepository;

class AttractionSearchService
{

    public function __construct(
        protected AttractionRepository $attractionRepo
    ) {}

    public function search(?string $location, ?string $checkdate)
    {
        $attraction = $this->attractionRepo->queryByLocationName($location);
        return [
            'location' => $location,
            'days' => $checkdate,
            'results' => $attraction
        ];
    }

    public function suggest(?string $keyword)
    {
        if (!$keyword) {
            return collect();
        }

        return $this->attractionRepo->suggest($keyword);
    }
}
