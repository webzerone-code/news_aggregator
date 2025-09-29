<?php

namespace App\Services\SearchNews;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;

class SearchBuilder
{
    protected Builder $builder;

    public function __construct()
    {
        $this->builder = News::query();
    }

    public function withCategory(int $category):self
    {
        $this->builder->when('category_id',fn($q) => $q->where('category_id',$category));
        return $this;
    }

    public function withTitle(string $title):self
    {
        $this->builder->when('title',fn($q) => $q->where('title','like','%'.$title.'%'));
        return $this;
    }
}
