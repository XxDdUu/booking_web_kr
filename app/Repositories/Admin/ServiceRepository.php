<?php

namespace App\Repositories\Admin;

use App\Models\Service;
use Illuminate\Support\Collection;

class ServiceRepository
{
    public function getForStayForm(): Collection
    {
        return Service::query()
            ->select('serviceID', 'serviceType')
            ->orderBy('serviceType')
            ->get();
    }
}
