<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Collection;

class GetProductData
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /** @return Collection<int, Product> */
    public function execute(): Collection
    {
        return $this->productService->getProducts();
    }
}
