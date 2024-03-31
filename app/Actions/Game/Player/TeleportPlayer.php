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
        $race = strtolower($player->race);
        $teleportData = Config::get("teleport.{$race}");

        $cooldownError = $this->checkTeleportCooldown->execute($player);

        if ($cooldownError) {
            return $cooldownError;
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
