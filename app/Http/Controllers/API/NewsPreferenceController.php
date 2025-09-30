<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;

class NewsPreferenceController extends Controller
{
    public function getPreference()
    {
        return response()->json([
            'categories'=>Category::all(),
            'sources'=>[],
            'perPage'=>[10,25,50,100],
        ],200);
    }
}
