<?php

namespace App\Actions\Game\Player;

use App\Models\Game\BaseGameModel;
use App\Models\Game\Player;
use App\Services\PlayerService;

class GetPlayer
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    public function execute(int $account, int $player_id): Player|BaseGameModel
    {
        return $this->playerService->getPlayerByAccountIdWithName($account, $player_id);
    }
}
