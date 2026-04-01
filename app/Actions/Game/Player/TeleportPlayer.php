<?php

declare(strict_types=1);

namespace App\Actions\Game\Player;

use App\Exceptions\TeleportCooldownException;
use App\Models\Game\Player;
use App\Services\PlayerService;
use App\Services\RechargeService;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use RuntimeException;

final class TeleportPlayer
{
    public function __construct(
        protected PlayerService $playerService,
        protected RechargeService $rechargeService,
        protected CheckTeleportCooldown $checkTeleportCooldown
    ) {}

    /**
     * @throws TeleportCooldownException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function execute(Player $player): void
    {
        $this->checkTeleportCooldown->execute($player);

        $race = strtolower($player->race);
        $allowedRaces = ['elyos', 'asmodians'];

        if (! in_array($race, $allowedRaces, true)) {
            throw new InvalidArgumentException('Invalid race.');
        }

        /** @var array{x: float, y: float, z: float, map: int}|null $teleportData */
        $teleportData = Config::get("teleport.{$race}");

        if (! $teleportData) {
            throw new RuntimeException('Teleport configuration not found.');
        }

        $teleportSuccess = $this->playerService->teleport(
            $player->account_id,
            $player->id,
            $teleportData['x'],
            $teleportData['y'],
            $teleportData['z'],
            $teleportData['map']
        );

        if (! $teleportSuccess) {
            throw new RuntimeException('Teleport failed.');
        }

        $this->rechargeService->createTeleportRecharge($player->id);
    }
}
