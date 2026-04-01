<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /** @return Collection<int, Product> */
    public function getProducts(): Collection
    {
        return Product::with('category')->get();
    }

    /** @return Collection<int, ProductCategory> */
    public function getProductCategories(): Collection
    {
        return ProductCategory::with('parent')->get();
    }

    public function incrementSalesCount(Product $product): void
    {
        $product->increment('sales_count');
    }
}
