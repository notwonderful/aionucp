<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class ArticleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $articles = Article::published()
            ->orderByDesc('published_at')
            ->paginate(20);

        return ArticleResource::collection($articles);
    }

    public function featured(): JsonResponse
    {
        $data = Cache::flexible('articles:featured', [300, 900], function () {
            return ArticleResource::collection(
                Article::published()
                    ->orderByDesc('published_at')
                    ->limit(4)
                    ->get()
            )->resolve();
        });

        return response()->json(['data' => $data]);
    }

    public function show(string $slug): ArticleResource
    {
        $article = Article::published()
            ->where('slug->en', $slug)
            ->orWhere('slug->ru', $slug)
            ->firstOrFail();

        return new ArticleResource($article);
    }
}
