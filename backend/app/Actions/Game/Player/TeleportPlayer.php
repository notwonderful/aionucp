<?php

declare(strict_types=1);

namespace App\Actions\Game\Player;

use App\Contracts\GameServerContract;
use App\Exceptions\TeleportCooldownException;
use App\Exceptions\TeleportException;
use App\Models\Game\Player;
use App\Services\RechargeService;
use App\Settings\TeleportSettings;
use Illuminate\Support\Facades\Cache;

final class TeleportPlayer
{
    public function __construct(
        private readonly GameServerContract $gameServer,
        private readonly RechargeService $rechargeService,
        private readonly CheckTeleportCooldown $checkTeleportCooldown,
        private readonly TeleportSettings $settings,
    ) {}

    /**
     * @throws TeleportCooldownException
     * @throws TeleportException
     */
    public function execute(Player $player, int $userId): void
    {
        $lock = Cache::lock("teleport_player_{$player->id}", $this->settings->cooldown_minutes * 60);

        if (! $lock->get()) {
            throw new TeleportException('Teleport is already in progress.');
        }

        try {
            $this->checkTeleportCooldown->execute($player, $userId);

            $teleportData = $this->settings->getCoordinates($player->race->value);

            $teleportSuccess = $this->gameServer->teleportPlayer(
                $player->account_id,
                $player->id,
                $teleportData['x'],
                $teleportData['y'],
                $teleportData['z'],
                $teleportData['map'],
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
