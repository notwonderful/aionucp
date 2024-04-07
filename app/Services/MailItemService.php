<?php

namespace App\Services;

use App\Models\Game\Inventory;
use App\Models\Game\MailItem;
use App\Models\Game\Player;
use Illuminate\Support\Facades\DB;

class MailItemService
{
    /**
     * @throws \Exception
     */
    public function sendMailItem(string $playerName, int $itemId, int $itemQty): bool
    {
        $player = Player::where('name', $playerName)->first();

        DB::transaction(function () use ($player, $itemId, $itemQty) {
            $uniqueItemId = $this->generateAttachedItemId();

            $inventoryItemData = [
                'item_unique_id' => $uniqueItemId,
                'item_id' => $itemId,
                'item_skin' => $itemId,
                'item_count' => $itemQty,
                'item_owner' => $player->id,
                'item_creator' => '',
                'item_location' => 127,
                'enchant' => 0,
                'authorize' => 0,
            ];

            $addInventoryItem = Inventory::create($inventoryItemData);
            if (! $addInventoryItem) {
                throw new \Exception('Error adding items to inventory.');
            }

            MailItem::create([
                'sender_name' => 'Admin',
                'mail_unique_id' => $this->generateUniqueMailId(),
                'mail_recipient_id' => $player->id,
                'mail_title' => __('Mail Item Service'),
                'mail_message' => __('Thank you for purchasing!'),
                'attached_item_id' => $uniqueItemId,
                'attached_item_count' => $itemQty,
                'attached_kinah_count' => 0,
                'express' => 1,
            ]);

            return true;
        });

        return false;
    }

    private function generateUniqueMailId(): int
    {
        $mailLastId = MailItem::max('mail_unique_id');
        return $mailLastId ? $mailLastId + 1 : 1;
    }

    private function generateAttachedItemId(): int
    {
        $inventoryLastId = Inventory::max('item_unique_id');
        return $inventoryLastId ? $inventoryLastId + 1 : 1;
    }
}
