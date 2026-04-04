<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\PurchaseProductAction;
use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ShopController extends Controller
{
    public function index(Request $request, ProductService $productService, GameServerContract $gameServer): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        return response()->json([
            'data' => [
                'products' => ProductResource::collection($productService->getProducts()),
                'players' => PlayerResource::collection($gameServer->getPlayersByAccountId($user->aion_acc_id)),
            ],
        ]);
    }

    public function buy(
        Product $product,
        Request $request,
        PurchaseProductAction $purchaseProductAction,
        GameServerContract $gameServer
    ): JsonResponse {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate([
            'player_id' => ['required', 'integer'],
        ]);

        $user = $request->user();
        assert($user instanceof User);

        /** @var int $playerId */
        $playerId = $validated['player_id'];
        $player = $gameServer->getPlayerByAccountId($user->aion_acc_id, $playerId);

        $purchaseProductAction->execute($user, $player, $product);

        return response()->json([
            'message' => __('Product bought successfully!'),
        ]);
    }
}
