<?php

namespace App\Services\DataPipeLine;

use App\Services\DataProcess\CategoriesProcess;

class CategoryParser
{
    private CategoriesProcess $categories;

    public function __construct(CategoriesProcess $categories)
    {
        $this->categories = $categories;
    }

    public function parse(string $title): ?int
    {
        return $this->categories->getDataCategories($title);
    }
}
