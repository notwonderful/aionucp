<?php

namespace App\Actions\Game\Player;

use App\Services\PlayerService;
use Illuminate\Database\Eloquent\Collection;

class GetPlayersAccount
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    public function execute(int $account): Collection
    {
        return $this->playerService->getPlayersByAccountId($account);
    }
}
