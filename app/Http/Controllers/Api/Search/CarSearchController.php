<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarSuggestResource;
use App\Services\Search\CarSearchService;
use Illuminate\Http\Request;

class CarSearchController extends Controller
{
    public function __construct(
        protected CarSearchService $service
    ) {}
    public function search(Request $request)
    {
        return response()->json(
            $this->service->search(
                $request->query('q'),
                $request->query('checkin'),
                $request->query('checkout')
            )
        );
    }
    public function suggest(Request $request)
    {
        $cars = $this->service->suggest(
            $request->query('q')
        );
        return response()->json(
            CarSuggestResource::collection($cars)->resolve()
        );
    }
}
