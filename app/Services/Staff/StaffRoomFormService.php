<?php

namespace App\Services\Staff;


use App\Repositories\RoomTypeRepository;
use Illuminate\Database\Eloquent\Collection;
class StaffRoomFormService
{
    public function __construct(
        protected RoomTypeRepository $roomTypeRepo,
    ) {}

    public function getFormData(): Collection
    {
        return $this->roomTypeRepo->getAll();
    }
}
