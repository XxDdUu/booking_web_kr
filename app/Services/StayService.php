<?php

namespace App\Services;
use App\Repositories\StayRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Support\Collection;

class StayService
{
    public function __construct(
        protected StayRepository $stayRepository,
        protected ReviewRepository $reviewRepository

    ) {}

    public function getCardStays(): Collection
    {
        return $this->stayRepository->getStaysForCard(8);
    }
    public function getStayById(string $id) {
        return $this->stayRepository->getStayById($id);
    } 
    public function deleteStayById(string $id) {}
    public function updateRating(string $serviceID): void
    {
        $avgRating = $this->reviewRepository
            ->getAverageRatingByService($serviceID);

        $this->stayRepository->updateRatingByService(
            $serviceID,
            $avgRating !== null ? round($avgRating, 1) : null
        );
    }
}
