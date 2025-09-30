<?php

namespace App\Services\DataProcess;

use App\Models\Category;

class CategoriesProcess
{
    private array $categories;

    public function __construct()
    {
        $this->loadCategories();
    }
    public function loadCategories() :void
    {
        $categories = Category::query()->get();
        foreach ($categories as $category) {
            $this->categories[$category->title] = ['id'=>$category->id, 'keywords'=>$category->keywords];
        }
    }

    public function getDataCategories(string $title):int
    {
        $title = strtolower($title);
        foreach($this->categories as $categoryTitle)
        {
            foreach($categoryTitle['keywords'] as $category)
            {
                if(str_contains($title, strtolower($category)))
                {
                    return $categoryTitle['id'];
                }
            }
        }
        return 1;
    }
}
