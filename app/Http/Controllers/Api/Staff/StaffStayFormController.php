<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Staff\StaffStayFormService;
class StaffStayFormController extends Controller
{
    public function __construct(
        protected StaffStayFormService $service
    ) {}
    public function getFormData()
    {
        $data = $this->service->getFormData();

        return response()->json($data);
    }
}
