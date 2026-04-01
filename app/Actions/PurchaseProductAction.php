<?php

namespace App\Actions;

use App\Exceptions\InsufficientBalanceException;
use App\Jobs\SendPurchaseToWebShopJob;
use App\Models\Game\AccountData;
use App\Models\Game\Player;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class PurchaseProductAction
{
    public function __construct(
        protected ProductService $productService,
    ) {}

    /**
     * @throws InsufficientBalanceException
     */
    public function execute(User $user, Player $player, Product $product): void
    {
        DB::transaction(function () use ($user, $player, $product) {
            $currentBalance = AccountData::query()
                ->where('id', $user->aion_acc_id)
                ->lockForUpdate()
                ->value('toll');

            /** @var int $currentBalance */
            if ($currentBalance < $product->toll) {
                throw new InsufficientBalanceException;
            }

            $user->decrement('balance', $product->toll);
            $this->productService->incrementSalesCount($product);
            dispatch(new SendPurchaseToWebShopJob($player, $product));
        });
    }
}
