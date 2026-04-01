<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters('name', 'category_id')
            ->allowedSorts('name', 'price', 'created_at')
            ->allowedIncludes('category')
            ->paginate();

        return ProductResource::collection($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')?->store('images/products', 'public');
        }

        $product = Product::create($validatedData);

        return response()->json([
            'message' => __('The product has been successfully created!'),
            'product' => new ProductResource($product),
        ], 201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('category'));
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => __('The product has been successfully updated!'),
            'product' => new ProductResource($product),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => __('The product has been successfully deleted!'),
        ]);
    }
}
