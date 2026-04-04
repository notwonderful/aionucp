<?php

declare(strict_types=1);

namespace App\Actions\Game\Player;

use App\Contracts\GameServerContract;
use App\Exceptions\TeleportCooldownException;
use App\Exceptions\TeleportException;
use App\Models\Game\Player;
use App\Services\RechargeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

final class TeleportPlayer
{
    public function __construct(
        protected GameServerContract $gameServer,
        protected RechargeService $rechargeService,
        protected CheckTeleportCooldown $checkTeleportCooldown
    ) {}

    /**
     * @throws TeleportCooldownException
     * @throws TeleportException
     */
    public function execute(Player $player, int $userId): void
    {
        /** @var int $cooldownMinutes */
        $cooldownMinutes = config('teleport.cooldown_teleport_minutes', 60);

        $lock = Cache::lock("teleport_player_{$player->id}", $cooldownMinutes * 60);

        if (! $lock->get()) {
            throw new TeleportException('Teleport is already in progress.');
        }

        try {
            $this->checkTeleportCooldown->execute($player, $userId);

            /** @var array{x: float, y: float, z: float, map: int}|null $teleportData */
            $teleportData = Config::get('teleport.' . strtolower($player->race->value));

            if (! $teleportData) {
                throw new TeleportException('Teleport configuration not found.');
            }

            $teleportSuccess = $this->gameServer->teleportPlayer(
                $player->account_id,
                $player->id,
                $teleportData['x'],
                $teleportData['y'],
                $teleportData['z'],
                $teleportData['map']
            );

            if (! $teleportSuccess) {
                throw new TeleportException('Teleport failed.');
            }

            $this->rechargeService->createTeleportRecharge($player->id, $userId);
        } finally {
            $lock->release();
        }
    }
}
