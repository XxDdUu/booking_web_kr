<?php

namespace App\Services\Search;

use App\Repositories\Stay\StayRepositoryInterface;
use Carbon\Carbon;

class StaySearchService
{
    public function __construct(
        protected StayRepositoryInterface $stayRepo
    ) {}
    public function search(?string $location, ?string $checkIn, ?string $checkOut)
    {
        $stays = $this->stayRepo->findByLocationName($location);

        $days = null;

        if ($checkIn && $checkOut) {
            $days = Carbon::parse($checkIn)
                ->diffInDays(Carbon::parse($checkOut));

            $stays->transform(function ($stay) use ($days) {
                $stay->days = $days;
                $stay->totalPrice = $stay->price * $days;
                return $stay;
            });
        }

        return [
            'location' => $location,
            'days' => $days,
            'results' => $stays
        ];
    }
    public function suggest(?string $keyword)
    {
        if (!$keyword) {
            return [];
        }

        return $this->stayRepo->suggest($keyword);
    }
}
