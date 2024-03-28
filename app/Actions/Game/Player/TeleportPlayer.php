<?php

namespace App\Actions\Game\Player;

use App\Models\Game\Player;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Config;

class TeleportPlayer
{
    public function __construct(
        protected PlayerService $playerService
    ) {}

    public function execute(Player $player): int
    {
        $race = strtolower($player->race);
        $teleportData = Config::get("teleport.{$race}");

        return $this->playerService->teleport(
            $player->account_id,
            $player->id,
            $teleportData['x'],
            $teleportData['y'],
            $teleportData['z'],
            $teleportData['map']
        );
    }
}
