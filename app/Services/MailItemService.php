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
    public function sendMailItem(string $playerName, int $itemId, int $itemQty): void
    {
        $player = Player::where('name', $playerName)->firstOrFail();

        DB::transaction(function () use ($player, $itemId, $itemQty) {
            $uniqueItemId = $this->generateAttachedItemId();

            Inventory::create([
                'item_unique_id' => $uniqueItemId,
                'item_id' => $itemId,
                'item_skin' => $itemId,
                'item_count' => $itemQty,
                'item_owner' => $player->id,
                'item_creator' => '',
                'item_location' => 127,
                'enchant' => 0,
                'authorize' => 0,
            ]);

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
        });
    }

    private function generateUniqueMailId(): int
    {
        /** @var int|null $maxId */
        $maxId = MailItem::max('mail_unique_id');

        return ($maxId ?? 0) + 1;
    }

    private function generateAttachedItemId(): int
    {
        /** @var int|null $maxId */
        $maxId = Inventory::max('item_unique_id');

        return ($maxId ?? 0) + 1;
    }
}
