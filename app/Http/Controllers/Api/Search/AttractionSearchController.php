<?php

namespace App\Http\Controllers\Api\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\Attraction\AttractionSuggestResource;
use App\Services\Search\AttractionSearchService;
use Illuminate\Http\Request;

class AttractionSearchController extends Controller
{
    public function __construct(
        protected AttractionSearchService $service
    ) {}
    public function search(Request $request)
    {
        return response()->json(
            $this->service->search(
                $request->query('q'),
                $request->query('checkdate'),
            )
        );
    }
    public function suggest(Request $request)
    {
        $attractions = $this->service->suggest(
            $request->query('q')
        );
        return response()->json(
            AttractionSuggestResource::collection($attractions)->resolve()
        );
    }
}