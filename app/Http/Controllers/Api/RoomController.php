<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Room\RoomResource;

use App\Services\RoomService;
use Log;
class RoomController extends Controller
{
    public function __construct(
        protected RoomService $service
    ) {}

    public function index(string $stayID)
    {
        $rooms = $this->service->getRooms($stayID);
        return RoomResource::collection($rooms);
    }
}