<?php

namespace App\Services\Search;

use App\Repositories\Car\CarRentalRepositoryInterface;
use Carbon\Carbon;
use Log;

class CarSearchService
{
    public function __construct(
        protected CarRentalRepositoryInterface $carRentalRepo
    ) {}

    public function search(?string $location, ?string $checkin, ?string $checkout)
    {
        $cars = $this->carRentalRepo->queryByLocationName($location);

        $days = null;

        if ($checkin && $checkout) {
            $days = Carbon::parse($checkin)
                ->diffInDays(Carbon::parse($checkout));

            $cars->whereHas('carRentals', function ($carRentalQuery) use ($checkin, $checkout) {
                $carRentalQuery->availableBetween($checkin, $checkout);
                Log::info('Get car rentals', $carRentalQuery->all());
            });
        }

        return [
            'location' => $location,
            'days' => $days,
            'results' => $cars
        ];
    }

    public function suggest(?string $keyword)
    {
        if (!$keyword) {
            return collect();
        }

        return $this->carRentalRepo->suggest($keyword);
    }
}
