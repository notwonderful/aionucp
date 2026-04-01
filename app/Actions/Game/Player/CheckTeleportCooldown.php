<?php

declare(strict_types=1);

namespace App\Actions\Game\Player;

use App\Exceptions\TeleportCooldownException;
use App\Models\Game\Player;
use App\Services\RechargeService;
use Illuminate\Support\Carbon;

final class CheckTeleportCooldown
{
    public function __construct(
        protected RechargeService $rechargeService,
    ) {}

    /**
     * @throws TeleportCooldownException
     */
    public function execute(Player $player): void
    {
        $lastTeleport = $this->rechargeService->getLastTeleport($player);

        if ($lastTeleport) {
            /** @var int $cooldownMinutes */
            $cooldownMinutes = config('teleport.cooldown_teleport_minutes', 60);
            $nextTeleportAt = Carbon::parse($lastTeleport->date)->addMinutes($cooldownMinutes);

            if ($nextTeleportAt->isFuture()) {
                throw new TeleportCooldownException($nextTeleportAt);
            }
        }
    }
}
