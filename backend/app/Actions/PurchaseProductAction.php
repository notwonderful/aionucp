<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\GameServerContract;
use App\Jobs\SendPurchaseToWebShopJob;
use App\Notifications\ShopPurchase;
use App\Models\Game\Player;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

final class PurchaseProductAction
{
    public function __construct(
        protected GameServerContract $gameServer,
        protected ProductService $productService,
    ) {}

    public function execute(User $user, Player $player, Product $product): void
    {
        DB::transaction(function () use ($user, $player, $product) {
            $this->gameServer->ensureSufficientBalance($user->aion_acc_id, $product->toll);
            $this->gameServer->decrementBalance($user->aion_acc_id, $product->toll);
            $this->productService->incrementSalesCount($product);
            dispatch(new SendPurchaseToWebShopJob($player, $product))->afterCommit();
            $user->notify(new ShopPurchase($product));
        });
    }
}
