<?php

namespace App\Services;

use App\Models\Game\Player;
use App\Models\Recharge;

class RechargeService
{
    public function createTeleportRecharge(int $charId): void
    {
        Recharge::create([
            'player_id' => $charId,
            'user_id' => auth()->id(),
            'type' => 'teleport',
            'date' => now(),
        ]);
    }

    public function getLastTeleport(Player $player): ?Recharge
    {
        return Recharge::where('player_id', $player->id)
            ->where('user_id', auth()->id())
            ->where('type', 'teleport')
            ->latest('date')
            ->first();
    }
}
