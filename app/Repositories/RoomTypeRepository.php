<?php

namespace App\Repositories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Collection;

class RoomTypeRepository
{
    public function getAll(): Collection
    {
        return RoomType::all();
    }
}
