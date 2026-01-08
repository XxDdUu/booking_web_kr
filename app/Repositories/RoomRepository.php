<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Collection;
use Log;
class RoomRepository
{
    public function get(
        string $stayID,
        ?string $checkIn = null,
        ?string $checkOut = null
    ): Collection {
        $query = Room::query()
            ->where('stayID', $stayID)
            ->with('roomTypeRelation');

        if ($checkIn && $checkOut) {
            $query->withAvailabilityBetween($stayID, $checkIn, $checkOut);
        }

        return $query->get();
    }
}

