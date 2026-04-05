<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class ArticleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters('tag', 'published')
            ->allowedSorts('title', 'published_at', 'created_at')
            ->defaultSort('-created_at')
            ->paginate();

        return ArticleResource::collection($articles);
    }

    public function store(ArticleRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')?->store('images/news', 'public');
        }

        $article = Article::create($data);

        return response()->json([
            'data' => new ArticleResource($article),
            'message' => __('News article created successfully!'),
        ], 201);
    }

    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article);
    }

    public function update(ArticleRequest $request, Article $article): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')?->store('images/news', 'public');
        }

        $article->update($data);

        return response()->json([
            'data' => new ArticleResource($article->fresh()),
            'message' => __('News article updated successfully!'),
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        return response()->json(status: 204);
    }
}
