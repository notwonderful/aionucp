<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

final class ProductPolicy
{
    public function buy(User $user, Product $product): bool
    {
        return $product->sales_count >= 0 && $product->toll > 0;
    }
}
