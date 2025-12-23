<?php

namespace App\Repositories;

use App\Models\Stay;
use Illuminate\Support\Collection;

class StayRepository
{
    public function getStaysForCard(int $limit = 10): Collection
    {
        return Stay::query()
            ->with([
                'location',
                'service',
                'category'
            ])
            ->limit($limit)
            ->get();
    }
    public function getStayById(string $id): Stay
    {
        return Stay::query()
            ->with([
                'location',
                'service',
                'category'
            ])
            ->where('stayID', $id)
            ->first();
    }
}
