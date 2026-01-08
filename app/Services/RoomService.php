<?php

namespace App\Services;

use App\Repositories\RoomRepository;
use Illuminate\Database\Eloquent\Collection;

class RoomService
{
    public function __construct(
        protected RoomRepository $repo
    ) {}

    public function getRooms(string $stayID): Collection
    {
        return $this->repo->get($stayID);
    }
    public function getAvailableRooms(string $stayID, string $checkIn, string $checkOut): Collection
    {
        return $this->repo->get($stayID, $checkIn, $checkOut);
    }
}
