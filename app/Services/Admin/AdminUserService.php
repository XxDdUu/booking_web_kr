<?php 

namespace App\Services\Admin;
use App\Repositories\Admin\AdminUserRepository;

class AdminUserService 
{
    public function __construct(
        protected AdminUserRepository $repo
    ) {}
    public function getCustomerAndStaff() {
        $user = $this->repo->getCustomerAndStaff();

        return [
            'customers' => $user->where('role', 'customer')->values(),
            'staff' => $user->where('role', 'staff')->values(),
        ];
    }
}