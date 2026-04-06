<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\Game\AccountData;
use App\Models\Game\Inventory;
use App\Models\Game\Player;
use App\Models\TrackedItem;

final class TrackItemAction
{
    public function execute(int $itemUniqueId): TrackedItem
    {
        $inventory = Inventory::where('item_unique_id', $itemUniqueId)->firstOrFail();

        $player = Player::find($inventory->item_owner);
        $account = $player ? AccountData::find($player->account_id) : null;

        return TrackedItem::create([
            'item_unique_id' => $inventory->item_unique_id,
            'item_id' => $inventory->item_id,
            'item_owner' => $inventory->item_owner,
            'item_count' => $inventory->item_count,
            'enchant' => $inventory->enchant,
            'item_creator' => $inventory->item_creator ?: null,
            'last_owner_name' => $player?->name ?? 'Unknown',
            'last_owner_account' => $account?->name ?? 'Unknown',
            'is_deleted' => false,
            'first_seen_at' => now(),
            'last_changed_at' => now(),
        ]);
    }
}
