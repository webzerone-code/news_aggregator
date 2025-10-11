<?php

namespace Architecture\Onion\Infrastructure\Persistence;

use Architecture\Onion\Domain\Entity\Article;
use Architecture\Onion\Domain\Repository\ArticleRepositoryInterface;
use App\Models\Article as Model;

class ArticleRepository implements ArticleRepositoryInterface
{
    protected Model $articleModel;
    public function __construct(Model $articleModel)
    {
        $this->articleModel = $articleModel;
    }
    public function insertArticle(Article $article) : Article
    {
        $insertedArticle = $this->articleModel::query()->create([
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
        ]);
        $article->setId($insertedArticle->id);
        return $article;
    }

    public function updateArticle(Article $article)
    {
        // TODO: Implement updateArticle() method.
    }

    public function GetArticleById(string $id)
    {
        // TODO: Implement GetArticleById() method.
    }


}
