<?php

namespace App\Services;

use App\Models\Game\BaseGameModel;
use App\Models\Game\Player;
use Illuminate\Database\Eloquent\Collection;

class PlayerService
{
    public function teleport(int $account, int $player, float $x, float $y, float $z, int $map): int
    {
        return Player::query()
            ->where('account_id', $account)
            ->where('id', $player)
            ->where('online', 0)
            ->update([
                'x' => $x,
                'y' => $y,
                'z' => $z,
                'world_id' => $map,
            ]);
    }

    public function getPlayersByAccountId(int $accountId): Collection
    {
        return Player::query()
            ->where('account_id', $accountId)
            ->select(['id', 'name'])
            ->get();
    }

    public function getPlayerByAccountIdWithName(int $accountId, int $player_id): Player|BaseGameModel
    {
        return Player::query()
            ->where('account_id', $accountId)
            ->where('id', $player_id)
            ->firstOrFail();
    }
}
