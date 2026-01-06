<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'roomID'       => $this->roomID,
            'stayID'       => $this->stayID,
            'roomTypeID'   => $this->roomTypeID,
            'roomType'     => $this->roomTypeRelation?->roomType,
            'roomName'     => $this->roomName,
            'description'  => $this->description,
            'quantity'     => $this->quantity,
            'capacity'     => $this->capacity,
            'currentPrice' => $this->currentPrice,
            'image'        => $this->image,
            'image_urls'   => $this->image_urls,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
