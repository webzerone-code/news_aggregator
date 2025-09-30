<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterNewsRequest
{
    public function __construct(){}
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page' => $request->get('page', 1),
            'title' => $request->get('title',''),
            'categories' => $request->get('categories',[]),
            'sources' => $request->get('sources',[]),
            'perPage' => $request->get('perPage',100),
        ];
    }
}
