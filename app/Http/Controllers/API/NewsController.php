<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilterNewsRequest;
use App\Http\Resources\NewsResponseResource;
use App\Services\SearchNews\SearchBuilder;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $parameters = app(FilterNewsRequest::class)->toArray($request);

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
}
