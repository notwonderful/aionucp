<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = QueryBuilder::for(ProductCategory::class)
            ->allowedFilters('name')
            ->allowedSorts('name', 'created_at')
            ->allowedIncludes('products', 'parent', 'children')
            ->paginate();

        return ProductCategoryResource::collection($categories);
    }

    public function store(ProductCategoryRequest $request): JsonResponse
    {
        $category = ProductCategory::create($request->validated());

        return response()->json([
            'message' => __('The product category has been successfully created!'),
            'category' => new ProductCategoryResource($category),
        ], 201);
    }

    public function show(ProductCategory $category): ProductCategoryResource
    {
        return new ProductCategoryResource($category->load(['products', 'parent', 'children']));
    }

    public function update(ProductCategoryRequest $request, ProductCategory $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json([
            'message' => __('The product category has been successfully updated!'),
            'category' => new ProductCategoryResource($category),
        ]);
    }

    public function destroy(ProductCategory $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'message' => __('The product category has been successfully deleted!'),
        ]);
    }
}
