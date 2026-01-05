<?php

namespace App\Services;

use App\Repositories\RoomRepository;

class RoomService
{
    public function __construct(
        protected RoomRepository $repo
    ) {}

    public function getRooms(string $stayID): array
    {
        return $this->repo->get($stayID);
    }
}
