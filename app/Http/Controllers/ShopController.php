<?php

namespace App\Http\Controllers;

use App\Actions\Game\Player\GetPlayer;
use App\Actions\Game\Player\GetPlayersAccount;
use App\Actions\GetProductData;
use App\Actions\PurchaseProductAction;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ShopController extends Controller
{
    public function index(GetProductData $getShopData, GetPlayersAccount $getPlayersAccount): View
    {
        $user = auth()->user();
        assert($user instanceof \App\Models\User);

        $products = $getShopData->execute();
        $players = $getPlayersAccount->execute($user->aion_acc_id);

        return view('pages.shop.create', compact('products', 'players'));
    }

    public function category(ProductCategory $category): View
    {
        $products = $category->products()->with('category')->get();

        return view('pages.shop.create', compact('products', 'category'));
    }

    /**
     * @throws \Exception
     */
    public function buy(
        Product $product,
        Request $request,
        PurchaseProductAction $purchaseProductAction,
        GetPlayer $getPlayer
    ): RedirectResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validate([
            'player_id' => ['required', 'integer'],
        ]);

        $user = auth()->user();
        assert($user instanceof \App\Models\User);

        /** @var int $playerId */
        $playerId = $validated['player_id'];

        $player = $getPlayer->execute($user->aion_acc_id, $playerId);

        /** @var \App\Models\Game\Player $player */
        $purchaseProductAction->execute($user, $player, $product);

        return redirect()->route('shop.index')
            ->with('success', __('Product bought successfully!'));
    }
}
