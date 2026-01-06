<?php

namespace App\Repositories\Staff;
use App\Models\Stay;
class StaffStayRepository
{
    public function create(array $data): Stay
    {
        return Stay::create($data);
    }
}
