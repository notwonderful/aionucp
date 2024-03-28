<?php

namespace App\Services;

use App\Models\Game\Player;

class PlayerService
{
    public function teleport(int $account, int $player, float $x, float $y, float $z, int $map): int
    {
        return Player::query()
            ->where('account_id', $account)
            ->where('id', $player)
            ->where('online', 0)
            ->select('x', 'y', 'z', 'world_id')
            ->update([
                'x' => $x,
                'y' => $y,
                'z' => $z,
                'world_id' => $map,
            ]);
    }
}
