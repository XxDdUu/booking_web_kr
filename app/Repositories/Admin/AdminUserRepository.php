<?php

namespace App\Repositories\Admin;

use App\Models\User;

class AdminUserRepository 
{
    public function getCustomerAndStaff() {
        return User::whereIn('role', ['staff', 'customer'])->get();
    }
}