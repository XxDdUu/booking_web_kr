<?php

namespace App\Http\Resources\Stay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaySuggestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stayID'      => $this->stayID,
            'stayName'    => $this->stayName,
            'address'     => $this->address,
            'locationName' => $this->location?->locationName,
            'country'      => $this->location?->country,
        ];
    }
}
