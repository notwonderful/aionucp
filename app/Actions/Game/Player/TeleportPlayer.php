<?php

namespace App\Actions\Game\Player;

use App\Models\Game\Player;
use App\Services\PlayerService;
use App\Services\RechargeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;

class TeleportPlayer
{
    public function __construct(
        protected PlayerService $playerService,
        protected RechargeService $rechargeService,
        protected CheckTeleportCooldown $checkTeleportCooldown
    ) {}

    public function execute(Player $player): RedirectResponse
    {
        $cooldownError = $this->checkTeleportCooldown->execute($player);

        if ($cooldownError) {
            return $cooldownError;
        }

        $race = strtolower($player->race);
        $allowedRaces = ['elyos', 'asmodians'];

        if (! in_array($race, $allowedRaces, true)) {
            return redirect()->back()->with('error', __('Invalid race.'));
        }

        /** @var array{x: float, y: float, z: float, map: int}|null $teleportData */
        $teleportData = Config::get("teleport.{$race}");

        if (! $teleportData) {
            return redirect()->back()->with('error', __('Teleport configuration not found.'));
        }

        $teleportSuccess = $this->playerService->teleport(
            $player->account_id,
            $player->id,
            $teleportData['x'],
            $teleportData['y'],
            $teleportData['z'],
            $teleportData['map']
        );

        if ($teleportSuccess) {
            $this->rechargeService->createTeleportRecharge($player->id);

            return redirect()->back()->with('success', __('Ваш персонаж успешно телепортирован!'));
        }

        return redirect()->back()->with('error', __('Что-то пошло не так!'));
    }
}
