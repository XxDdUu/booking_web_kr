<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarSuggestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'carName' => $this->car?->carName,
            'checkInDestination' => $this->location?->locationName,
            'country' => $this->location?->country,
        ];
    }
}
