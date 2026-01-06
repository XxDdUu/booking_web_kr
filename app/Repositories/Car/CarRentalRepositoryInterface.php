<?php
namespace App\Repositories\Car;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Collection;

interface CarRentalRepositoryInterface
{
    public function suggest(string $keyword, int $limit = 8): Collection;
    public function queryByLocationName(?string $location): Builder;
    public function getCarsForCard(int $limit = 10);
    public function getCarRentalById(string $id);
    public function updateRatingByService(string $serviceID, float $rating);
}
