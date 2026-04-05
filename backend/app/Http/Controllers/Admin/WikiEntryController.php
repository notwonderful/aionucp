<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WikiEntryRequest;
use App\Http\Resources\WikiEntryResource;
use App\Models\WikiEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class WikiEntryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $entries = QueryBuilder::for(WikiEntry::class)
            ->with('category')
            ->allowedFilters(
                AllowedFilter::exact('wiki_category_id'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('published'),
            )
            ->allowedSorts('sort_order', 'created_at')
            ->defaultSort('sort_order')
            ->paginate(50);

        return WikiEntryResource::collection($entries);
    }

    public function store(WikiEntryRequest $request): JsonResponse
    {
        $entry = WikiEntry::create($request->validated());

        return response()->json([
            'data' => new WikiEntryResource($entry->load('category')),
            'message' => __('Wiki entry created successfully!'),
        ], 201);
    }

    public function show(WikiEntry $wiki): WikiEntryResource
    {
        return new WikiEntryResource($wiki->load('category'));
    }

    public function update(WikiEntryRequest $request, WikiEntry $wiki): JsonResponse
    {
        $wiki->update($request->validated());

        return response()->json([
            'data' => new WikiEntryResource($wiki->fresh()->load('category')),
            'message' => __('Wiki entry updated successfully!'),
        ]);
    }

    public function destroy(WikiEntry $wiki): JsonResponse
    {
        $wiki->delete();

        return response()->json(status: 204);
    }
}
