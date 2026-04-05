<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class FaqController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $faqs = QueryBuilder::for(Faq::class)
            ->allowedFilters('published')
            ->allowedSorts('sort_order', 'created_at')
            ->defaultSort('sort_order')
            ->paginate();

        return FaqResource::collection($faqs);
    }

    public function store(FaqRequest $request): JsonResponse
    {
        $faq = Faq::create($request->validated());

        return response()->json([
            'data' => new FaqResource($faq),
            'message' => __('FAQ created successfully!'),
        ], 201);
    }

    public function show(Faq $faq): FaqResource
    {
        return new FaqResource($faq);
    }

    public function update(FaqRequest $request, Faq $faq): JsonResponse
    {
        $faq->update($request->validated());

        return response()->json([
            'data' => new FaqResource($faq->fresh()),
            'message' => __('FAQ updated successfully!'),
        ]);
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json(status: 204);
    }
}
