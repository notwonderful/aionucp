<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Game\AccountData;
use App\Models\Game\Inventory;
use App\Models\Game\Player;
use App\Models\ItemTrackerLog;
use App\Models\TrackedItem;
use Illuminate\Console\Command;

final class TrackItemsCommand extends Command
{
    protected $signature = 'app:track-items';

    protected $description = 'Scan inventories for tracked item ownership changes';

    public function handle(): void
    {
        $trackedItems = TrackedItem::where('is_deleted', false)->get();

        if ($trackedItems->isEmpty()) {
            $this->info('No items being tracked.');

            return;
        }

        $trackedIds = $trackedItems->pluck('item_unique_id')->all();

        $currentInventory = Inventory::whereIn('item_unique_id', $trackedIds)
            ->get()
            ->keyBy('item_unique_id');

        $changedPlayerIds = [];

        foreach ($trackedItems as $tracked) {
            $inventoryItem = $currentInventory->get($tracked->item_unique_id);

            if (! $inventoryItem) {
                $this->handleDeletedItem($tracked);

                continue;
            }

            if ((int) $inventoryItem->item_owner !== $tracked->item_owner) {
                $changedPlayerIds[] = (int) $inventoryItem->item_owner;
            }
        }

        $players = [];
        $accounts = [];

        if (! empty($changedPlayerIds)) {
            $uniqueIds = array_unique($changedPlayerIds);
            $players = Player::whereIn('id', $uniqueIds)->get()->keyBy('id');
            $accountIds = $players->pluck('account_id')->unique()->all();
            $accounts = AccountData::whereIn('id', $accountIds)->get()->keyBy('id');
        }

        $transfers = 0;
        $updates = 0;

        foreach ($trackedItems as $tracked) {
            $inventoryItem = $currentInventory->get($tracked->item_unique_id);

            if (! $inventoryItem) {
                continue;
            }

            $newOwnerId = (int) $inventoryItem->item_owner;

            if ($newOwnerId !== $tracked->item_owner) {
                $newPlayer = $players->get($newOwnerId);
                $newAccount = $newPlayer ? $accounts->get($newPlayer->account_id) : null;

                ItemTrackerLog::create([
                    'item_unique_id' => $tracked->item_unique_id,
                    'item_id' => $tracked->item_id,
                    'old_owner_id' => $tracked->item_owner,
                    'old_owner_name' => $tracked->last_owner_name,
                    'old_owner_account' => $tracked->last_owner_account,
                    'new_owner_id' => $newOwnerId,
                    'new_owner_name' => $newPlayer?->name ?? 'Unknown',
                    'new_owner_account' => $newAccount?->name ?? 'Unknown',
                    'event_type' => 'transfer',
                    'logged_at' => now(),
                ]);

                $tracked->update([
                    'item_owner' => $newOwnerId,
                    'last_owner_name' => $newPlayer?->name ?? 'Unknown',
                    'last_owner_account' => $newAccount?->name ?? 'Unknown',
                    'item_count' => $inventoryItem->item_count,
                    'enchant' => $inventoryItem->enchant,
                    'last_changed_at' => now(),
                ]);

                $transfers++;
            } elseif ((int) $inventoryItem->enchant !== $tracked->enchant || (int) $inventoryItem->item_count !== $tracked->item_count) {
                $tracked->update([
                    'item_count' => $inventoryItem->item_count,
                    'enchant' => $inventoryItem->enchant,
                    'last_changed_at' => now(),
                ]);

                $updates++;
            }
        }

        $this->info("Tracked {$trackedItems->count()} items: {$transfers} transfers, {$updates} updates.");
    }

    private function handleDeletedItem(TrackedItem $tracked): void
    {
        if ($tracked->is_deleted) {
            return;
        }

        ItemTrackerLog::create([
            'item_unique_id' => $tracked->item_unique_id,
            'item_id' => $tracked->item_id,
            'old_owner_id' => $tracked->item_owner,
            'old_owner_name' => $tracked->last_owner_name,
            'old_owner_account' => $tracked->last_owner_account,
            'new_owner_id' => null,
            'new_owner_name' => null,
            'new_owner_account' => null,
            'event_type' => 'deleted',
            'logged_at' => now(),
        ]);

        $tracked->update([
            'is_deleted' => true,
            'last_changed_at' => now(),
        ]);
    }
}
