<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->reviewID,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' => $this->created_at,

            'user' => $this->whenLoaded('user', [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar_url' => $this->user->avatar_url,
            ]),
        ];
    }
}
