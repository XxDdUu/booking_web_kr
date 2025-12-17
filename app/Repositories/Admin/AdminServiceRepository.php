<?php

namespace App\Repositories\Admin;

use App\Models\Service;
use Illuminate\Support\Collection;

class AdminServiceRepository
{
    public function getForStayForm(): Collection
    {
        return Service::query()
            ->select('serviceID', 'serviceType')
            ->orderBy('serviceType')
            ->get();
    }
}
