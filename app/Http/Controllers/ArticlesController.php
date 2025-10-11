<?php

namespace App\Http\Controllers;

use Architecture\Onion\Application\Services\ArticleService;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        // Either bind the article services to ArticleRepository Or make copy

        $this->articleService = $articleService;
    }
    public function add_article()
    {
        $articleObject = $this->articleService->createArticle("My Article Title", "My Article Content");
        return ['id'=>$articleObject->getId(),'title'=>$articleObject->getTitle(),'content'=>$articleObject->getContent()];
        return "welcome to Onion Architecture";
    }
}
