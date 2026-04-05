<?php

declare(strict_types=1);

namespace App\Actions\Game;

use App\Contracts\GameServerContract;
use App\Models\MailItemLog;

final class SendMailItemAction
{
    public function __construct(
        private readonly GameServerContract $gameServer,
    ) {}

    public function execute(string $playerName, int $itemId, int $itemQty, int $adminId): void
    {
        $this->gameServer->sendMailItem($playerName, $itemId, $itemQty);

        MailItemLog::create([
            'admin_id' => $adminId,
            'player_name' => $playerName,
            'item_id' => $itemId,
            'item_qty' => $itemQty,
        ]);
    }
}
