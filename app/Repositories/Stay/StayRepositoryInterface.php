<?php
namespace App\Repositories\Stay;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Collection;

interface StayRepositoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection;
    public function queryByLocationName(?string $location): Builder;
    public function getStaysForCard(int $limit = 10);
    public function getStayById(string $id);
    public function updateRatingByService(string $serviceID, float $rating);
}
