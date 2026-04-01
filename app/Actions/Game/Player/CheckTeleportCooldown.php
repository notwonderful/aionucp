<?php

namespace App\Actions\Game\Player;

use App\Models\Game\Player;
use App\Services\RechargeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class CheckTeleportCooldown
{
    public function __construct(
        protected RechargeService $rechargeService,
    ) {}

    public function execute(Player $player): ?RedirectResponse
    {
        $lastTeleport = $this->rechargeService->getLastTeleport($player);

        if ($lastTeleport) {
            /** @var int $cooldownMinutes */
            $cooldownMinutes = config('teleport.cooldown_teleport_minutes', 60);
            $nextTeleportAt = Carbon::parse($lastTeleport->date)->addMinutes($cooldownMinutes);

            if ($nextTeleportAt->isFuture()) {
                return redirect()->back()->with('error', __('Error! It will be possible to teleport again after :time', ['time' => $nextTeleportAt->diffForHumans()]));
            }
        }

        return null;
    }
}
