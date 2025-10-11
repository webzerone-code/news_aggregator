<?php

namespace App\Providers;

use Architecture\Onion\Application\Services\ArticleService;
use Architecture\Onion\Domain\Repository\ArticleRepositoryInterface;
use Architecture\Onion\Persistence\Repositories\ArticleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
