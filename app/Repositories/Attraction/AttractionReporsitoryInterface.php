<?php

namespace App\Repositories\Attraction;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface AttractionReporsitoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection;
    public function queryByLocationName(?string $location): Builder;
    public function getAttractionsForCard(int $limit = 10);
    public function getAttractionById(string $id);
    public function updateRatingByService(string $serviceID, float $rating);
}
