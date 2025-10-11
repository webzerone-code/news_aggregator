<?php

namespace Architecture\Onion\Domain\Repository;

use Architecture\Onion\Domain\Entity\Article;

interface ArticleRepositoryInterface
{
    public function insertArticle(Article $article) : Article;
    public function updateArticle(Article $article);//: Article;
    public function GetArticleById(string $id);//: Article;
}
