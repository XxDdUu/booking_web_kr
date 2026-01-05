<?php

namespace App\Repositories\Staff;
use App\Models\Room;
class StaffRoomRepository
{
    public function create(string $stayID, array $data): Room
    {
        $data['stayID'] = $stayID;
        return Room::create($data);
    }
}
