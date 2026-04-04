<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ProductService
{
    /** @return LengthAwarePaginator<int, Product> */
    public function getProducts(): LengthAwarePaginator
    {
        return Product::query()
            ->select(['id', 'name', 'slug', 'description', 'toll', 'item_id', 'item_qty', 'image', 'sales_count', 'category_id'])
            ->with('category:id,name,slug,parent_id')
            ->paginate();
    }

    public function incrementSalesCount(Product $product): void
    {
        $product->increment('sales_count');
    }
}
