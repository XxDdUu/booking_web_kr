<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Collection;

class RoomRepository
{
    public function get(string $stayID): Collection
    {
        return Room::where('stayID', $stayID)->get();
    }
}
