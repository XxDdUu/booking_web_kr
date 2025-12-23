<?php

namespace App\Factories;

use App\Models\Service;

class ServiceFactory
{
    public static function create(string $type): string
    {
        return Service::create([
            'serviceType' => $type,
        ])->serviceID;
    }
}
