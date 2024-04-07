<?php

namespace App\Services;

use App\Models\Game\Player;
use App\Models\Game\WebShop;
use App\Models\Product;

class WebShopService
{
    public function createWebShopItem(Player $player, Product $product): void
    {
        WebShop::create([
            'recipient' => $player->name,
            'item_desc' => $product->name,
            'item_id' => $product->item_id,
            'count' => $product->item_qty,
            'toll' => $product->toll,
            'balanced' => true,
            'send' => true,
            'shop_type' => 'PRODUCT',
            'time_received' => now(),
        ]);
    }
}
