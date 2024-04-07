<?php

namespace App\Actions;

use App\Jobs\SendPurchaseToWebShopJob;
use App\Models\Game\Player;
use App\Models\Product;
use App\Models\User;
use App\Services\PlayerService;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class PurchaseProductAction
{
    public function __construct(
        protected ProductService $productService,
        protected PlayerService $playerService
    ) {}

    /**
     * @throws \Exception
     */
    public function execute(User $user, Player $player, Product $product): void
    {
        DB::transaction(function () use ($user, $player, $product) {
            if ($user->balance >= $product->toll) {
                $user->decrement('balance', $product->toll);
                $this->productService->incrementSalesCount($product);
                dispatch(new SendPurchaseToWebShopJob($player, $product));
            }
        });
    }
}
