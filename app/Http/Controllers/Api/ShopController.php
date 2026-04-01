<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Game\Player\GetPlayer;
use App\Actions\Game\Player\GetPlayersAccount;
use App\Actions\GetProductData;
use App\Actions\PurchaseProductAction;
use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\ProductResource;
use App\Models\Game\Player;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShopController extends Controller
{
    public function index(Request $request, GetProductData $getShopData, GetPlayersAccount $getPlayersAccount): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $products = $getShopData->execute();
        $players = $getPlayersAccount->execute($user->aion_acc_id);

        return response()->json([
            'data' => [
                'products' => ProductResource::collection($products),
                'players' => PlayerResource::collection($players),
            ],
        ]);
    }

    public function buy(
        Product $product,
        Request $request,
        PurchaseProductAction $purchaseProductAction,
        GetPlayer $getPlayer
    ): JsonResponse {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate([
            'player_id' => ['required', 'integer'],
        ]);

        $user = $request->user();
        assert($user instanceof User);

        /** @var int $playerId */
        $playerId = $validated['player_id'];
        $player = $getPlayer->execute($user->aion_acc_id, $playerId);

        try {
            /** @var Player $player */
            $purchaseProductAction->execute($user, $player, $product);
        } catch (InsufficientBalanceException) {
            return response()->json([
                'message' => __('Not enough balance to purchase.'),
            ], 422);
        }

        return response()->json([
            'message' => __('Product bought successfully!'),
        ]);
    }
}
