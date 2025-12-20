<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StayHomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'stayName' => $this->stayName,
            'location' => optional($this->location)->locationName,
            'address' => $this->address,
            'rating' => $this->rating,
            'price' => $this->price,
            'image_url' => $this->image_urls[0] ?? null,
        ];
    }
}
