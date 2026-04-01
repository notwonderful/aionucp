<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\ProductCategory as ProductCategoryModel;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;

class GetProductCategory
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /** @return Collection<int, ProductCategoryModel> */
    public function execute(): Collection
    {
        return $this->productService->getProductCategories();
    }
}
