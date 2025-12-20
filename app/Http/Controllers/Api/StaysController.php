<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StayService;
use App\Http\Resources\StayHomeResource;

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
}
