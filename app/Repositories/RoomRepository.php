<?php

namespace App\Repositories;

use App\Models\Room;

class RoomRepository
{
    public function get(string $stayID): array
    {
        return Room::where('stayID', $stayID)->get()->toArray();
    }
}
