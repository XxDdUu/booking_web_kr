<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\RoomService;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $service
    ) {}

    public function index(string $stayID)
    {
        $rooms = $this->service->getRooms($stayID);
        return response()->json([
            'ok'   => true,
            'data' => $rooms
        ]);
    }
}