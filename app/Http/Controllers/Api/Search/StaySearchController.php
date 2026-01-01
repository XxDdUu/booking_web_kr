<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Services\Search\StaySearchService;
use App\Http\Resources\StaySuggestResource;
use Illuminate\Http\Request;
use Log;

class StaySearchController extends Controller
{
    public function __construct(
        protected StaySearchService $service
    ) {}
    public function search(Request $request)
    {
        return response()->json(
            $this->service->search(
                $request->query('query'),
                $request->query('checkin'),
                $request->query('checkout')
            )
        );
    }
    public function suggest(Request $request)
    {
        $stays = $this->service->suggest(
            $request->query('q')
        );
        return response()->json(
            StaySuggestResource::collection($stays)->resolve());
    }
}
