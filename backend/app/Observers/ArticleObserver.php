<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

final class ArticleObserver
{
    public function saved(Article $article): void
    {
        Cache::forget('articles:featured');
    }

    public function deleted(Article $article): void
    {
        Cache::forget('articles:featured');
    }
}
