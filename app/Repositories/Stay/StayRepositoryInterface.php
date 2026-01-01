<?php
namespace App\Repositories\Stay;

use Illuminate\Support\Collection;

interface StayRepositoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection;
    public function findByLocationName(string $location): Collection;
    public function getStaysForCard(int $limit = 10);
    public function getStayById(string $id);
    public function updateRatingByService(string $serviceID, float $rating);
}
