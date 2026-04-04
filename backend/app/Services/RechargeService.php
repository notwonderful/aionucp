<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RechargeType;
use App\Models\Game\Player;
use App\Models\Recharge;

final class RechargeService
{
    public function createTeleportRecharge(int $charId, int $userId): void
    {
        Recharge::create([
            'player_id' => $charId,
            'user_id' => $userId,
            'type' => RechargeType::TELEPORT,
            'date' => now(),
        ]);
    }

    public function getLastTeleport(Player $player, int $userId): ?Recharge
    {
        return Recharge::where('player_id', $player->id)
            ->where('user_id', $userId)
            ->where('type', RechargeType::TELEPORT)
            ->latest('date')
            ->first();
    }
}
