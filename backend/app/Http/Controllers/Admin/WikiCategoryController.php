<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\WikiCategoryResource;
use App\Models\WikiCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class WikiCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = QueryBuilder::for(WikiCategory::class)
            ->withCount('entries')
            ->allowedSorts('sort_order', 'name', 'created_at')
            ->defaultSort('sort_order')
            ->paginate(50);

        return WikiCategoryResource::collection($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:50', 'unique:wiki_categories,slug'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'published' => ['required', 'boolean'],
        ]);

        $category = WikiCategory::create($data);

        return response()->json([
            'data' => new WikiCategoryResource($category),
            'message' => __('Wiki category created successfully!'),
        ], 201);
    }

    public function show(WikiCategory $wikiCategory): WikiCategoryResource
    {
        return new WikiCategoryResource($wikiCategory->loadCount('entries'));
    }

    public function update(Request $request, WikiCategory $wikiCategory): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:50', 'unique:wiki_categories,slug,'.$wikiCategory->id],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
            'published' => ['required', 'boolean'],
        ]);

        $wikiCategory->update($data);

        return response()->json([
            'data' => new WikiCategoryResource($wikiCategory->fresh()->loadCount('entries')),
            'message' => __('Wiki category updated successfully!'),
        ]);
    }

    public function destroy(WikiCategory $wikiCategory): JsonResponse
    {
        $wikiCategory->delete();

        return response()->json(status: 204);
    }
}
