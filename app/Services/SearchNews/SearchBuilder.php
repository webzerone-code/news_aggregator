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

    public function withTitle(string $title):self
    {
        $this->builder->when('title',fn($q) => $q->where('title','like','%'.$title.'%'));
        return $this;
    }

    public function withCategories(array $categories):self
    {
        $this->builder->when('category_id',fn($q) => $q->where('category_id',$categories));
        return $this;
    }
    public function withSources(array $sources):self
    {
        $this->builder->when('source',fn($q) => $q->whereIn('source',$sources));
        return $this;
    }
    public function paginate(int $perPage): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->builder->orderBy('published_at')->paginate($perPage);
    }
}
