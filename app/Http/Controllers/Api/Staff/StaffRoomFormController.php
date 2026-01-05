<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Services\Staff\StaffRoomFormService;
use App\Http\Resources\RoomType\RoomTypeResource;
use Log;
class StaffRoomFormController extends Controller
{
    public function __construct(
        protected StaffRoomFormService $service
    ) {}
    public function getFormData()
    {
        $data = $this->service->getFormData();

        return RoomTypeResource::collection($data);
    }
}
