<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Staff\StayFormService;
class StayFormController extends Controller
{
    public function __construct(
        protected StayFormService $service
    ) {}
    public function getFormData()
    {
        $data = $this->service->getFormData();

        return response()->json($data);
    }
}
