<?php

namespace App\Repositories\Admin;

use App\Models\User;

class AdminUserRepository 
{
    public function getByRoles(array $roles) {
        return User::query()
            ->whereIn('role', $roles)
            ->withCount([
            'bookings as bookingCount'
        ])
        ->get();
    }
    public function getByRolesWithBookingCount(array $roles)
    {
        return User::withCount([
            'bookings as bookingCount'
        ])->whereIn('role', $roles)->get();
    }

}