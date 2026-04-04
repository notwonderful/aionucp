<?php

declare(strict_types=1);

namespace App\Actions\Game;

use App\Contracts\GameServerContract;

final class SendMailItemAction
{
    public function __construct(
        protected GameServerContract $gameServer
    ) {}

    /**
     * @throws \Exception
     */
    public function execute(string $playerName, int $itemId, int $itemQty): void
    {
        $this->gameServer->sendMailItem($playerName, $itemId, $itemQty);
    }
}
