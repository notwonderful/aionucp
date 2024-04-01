<?php

namespace App\Actions;

use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;

class GetProductCategory
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function execute(): Collection|array
    {
        return $this->productService->getProductCategories();
    }
}
