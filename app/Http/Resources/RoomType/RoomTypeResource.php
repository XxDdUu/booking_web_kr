<?php

namespace App\Http\Resources\RoomType;
use Illuminate\Http\Resources\Json\JsonResource;
class RoomTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'roomTypeID'   => $this->roomTypeID,
            'roomType' => $this->roomType,
        ];
    }
}
