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
    public function available(Request $request, string $stayID) {
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');
        $availableRooms = $this->service->getAvailableRooms($stayID, $checkIn, $checkOut);
        return RoomResource::collection($availableRooms);
    }

}