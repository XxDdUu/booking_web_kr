<?php

namespace App\Http\Resources\Attraction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttractionSuggestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attractionID' => $this->attractionID,
            'attractionName' => $this->attractionName,
            'categoryName' => $this->category?->categoryName,
            'locationName' => $this->location?->locationName,
            'country' => $this->location?->country
        ];
    }
}
