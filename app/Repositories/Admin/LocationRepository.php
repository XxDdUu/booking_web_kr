<?php

namespace App\Repositories\Admin;

use App\Models\Location;

class LocationRepository
{
    public function create(array $data): Location
    {
        return Location::create($data);
    }
    public function update(string $locationID, array $data): Location
    {
        $location = Location::findOrFail($locationID);
        if (! $location) {
            throw new \Exception("Location not found");
        }
        $location->update($data);
        return $location;
    }
    public function getAll()
    {
        return Location::orderBy('created_at', 'desc')->get();
    }
    public function paginate(int $perPage = 10)
    {
        return Location::orderBy('created_at', 'desc')->paginate($perPage);
    }
}
