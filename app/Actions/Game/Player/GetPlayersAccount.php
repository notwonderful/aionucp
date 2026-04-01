<?php

declare(strict_types=1);

namespace App\Actions\Game\Player;

use App\Models\Game\Player;
use App\Services\PlayerService;
use Illuminate\Database\Eloquent\Collection;

class GetPlayersAccount
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    /** @return Collection<int, Player> */
    public function execute(int $account): Collection
    {
        return $this->playerService->getPlayersByAccountId($account);
    }
}
