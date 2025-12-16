<?php

namespace App\Repositories\Staff;
use App\Models\Stay;
class StayRepository
{
    public function create(array $data): Stay
    {
        return Stay::create($data);
    }
}
