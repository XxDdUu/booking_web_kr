<?php

namespace App\Services\Search;

use App\Repositories\Stay\StayRepositoryInterface;
use Carbon\Carbon;
use Log;
class StaySearchService
{
    public function __construct(
        protected StayRepositoryInterface $stayRepo
    ) {}
    public function search(?string $location, ?string $checkIn, ?string $checkOut)
    {
        $stays = $this->stayRepo->queryByLocationName($location);

        $days = null;

        if ($checkIn && $checkOut) {
            $days = Carbon::parse($checkIn)
                ->diffInDays(Carbon::parse($checkOut));

                $stays->whereHas('rooms', function ($roomQuery) use ($checkIn, $checkOut) {
                    $roomQuery->availableBetween($checkIn, $checkOut);
                Log::info($roomQuery->all());
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
