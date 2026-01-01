<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaySuggestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stayName'     => $this->stayName,
            'locationName' => $this->location?->locationName,
            'country'      => $this->location?->country,
        ];
    }
}
