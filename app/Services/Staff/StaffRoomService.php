<?php
namespace App\Services\Staff;
use App\Repositories\Staff\StaffRoomRepository;
use Illuminate\Support\Facades\DB;
class StaffRoomService
{
    public function __construct(
        protected StaffRoomRepository $repo
    ) {}

    public function createRoom(string $stayID, array $data)
    {
        return $this->repo->create($stayID, $data);
    }
}
