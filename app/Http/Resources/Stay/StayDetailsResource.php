<?php

namespace App\Http\Resources\Stay;

use App\Http\Resources\ReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StayDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'stayID' => $this->stayID,
            'serviceID' => $this->serviceID,
            'stayName' => $this->stayName,
            'description' => $this->description,
            'address' => $this->address,
            'rating' => $this->rating,
            'price' => $this->price,

            'image_urls' => $this->image_urls ?? [],

            'location' => $this->whenLoaded(
                'location',
                fn () => $this->location->locationName
            ),

            'category' => $this->whenLoaded(
                'category',
                fn () => $this->category->categoryName
            ),
            'service' => $this->whenLoaded(
                'service',
                fn () => $this->service->serviceType
            ),
            'reviews' => ReviewResource::collection(
                $this->whenLoaded('reviews')
            ),
        ];
    }
}
