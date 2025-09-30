<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilterNewsRequest;
use App\Http\Resources\NewsResponseResource;
use App\Services\SearchNews\SearchBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $parameters = $this->resolveParameters($request);
        $data = App(SearchBuilder::class)
            ->withRelation(['category'])
            ->withTitle($parameters['title'])
            ->withCategories($parameters['categories'])
            //->withSources($parameters['sources'])
            ->orderBy('published_at')
            ->paginate($parameters['perPage']);
        $items = NewsResponseResource::collection($data->getCollection());
        return response()->json([
            'data' => $items,
            'page' => $data->currentPage(),
            'pages' => $data->lastPage(),
        ],200);
    }

    private function resolveParameters(Request $request) : array
    {
        $parameters = app(FilterNewsRequest::class)->toArray($request);
        $preferences = Auth::user()->preferences ?? null;
        if($preferences)
        {
            if($preferences->preferences['categories'] && count($parameters['categories']) == 0)
                $parameters['categories'] = $preferences->preferences['categories'];
            if($preferences->preferences['sources'] && count($parameters['sources']) == 0)
                $parameters['sources'] = $preferences->preferences['sources'];
            if($preferences->preferences['perPage'] && !$parameters['sources'])
                $parameters['perPage'] = $preferences->preferences['perPage'];
        }

        return $parameters;
    }
}
