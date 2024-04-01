<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function getProducts(): Collection|array
    {
        return Product::with('category')->get();
    }

    public function getProductCategories(): Collection|array
    {
        return ProductCategory::with('parent')->get();
    }
}
