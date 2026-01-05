<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StayService;
use App\Http\Resources\Stay\StayHomeResource;
use App\Http\Resources\Stay\StayDetailsResource;
class StaysController extends Controller
{
    public function __construct(
        protected StayService $service
    ){} 
    public function index()
    {
        return StayHomeResource::collection(
            $this->service->getCardStays()
        );
    }
    public function show(string $id) {
        return new StayDetailsResource(
            $this->service->getStayById($id)
        );
    }
    public function destroy()  {
        
    }
}
