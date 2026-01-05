<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminUserService;

class AdminUserController extends Controller
{
    protected AdminUserService $service;

    public function __construct(AdminUserService $service)
    {
        $this->service = $service;
    }

    public function getCustomerAndStaff()
    {
        $data = $this->service->getCustomerAndStaff();

        return response()->json([
            'message' => 'Get customer and staff successfully',
            'data' => $data
        ]);
    }
}
