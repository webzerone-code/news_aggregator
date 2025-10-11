<?php

namespace Architecture\Onion\Application\Services;

use Architecture\Onion\Domain\Entity\Article;
use Architecture\Onion\Domain\Repository\ArticleRepositoryInterface;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function createArticle(string $title,string $content) : Article
    {
        $article = new Article();
        $article->setTitle($title);
        $article->setContent($content);

        $this->articleRepository->insertArticle($article);
        // Need to change to return the actual inserted Article line 23
        return $article;
    }
}
