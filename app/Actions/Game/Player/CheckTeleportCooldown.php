<?php

namespace App\Actions\Game\Player;

use App\Models\Game\Player;
use App\Services\RechargeService;
use Illuminate\Http\RedirectResponse;

class CheckTeleportCooldown
{
    public function __construct(
        protected RechargeService $rechargeService,
    ) {}

    public function execute(Player $player): ?RedirectResponse
    {
        $lastTeleport = $this->rechargeService->getLastTeleport($player);

        if ($lastTeleport) {
            $cooldownTime = config('teleport.cooldown_teleport_minutes');
            $date = strtotime(date('Y-m-d H:i:s'));
            $dateRecharge = strtotime($lastTeleport->date) + 60 * $cooldownTime;

            if ($dateRecharge > $date) {
                return redirect()->back()->with('error', __('Error! It will be possible to teleport again after :time', ['time' => $cooldownTime]));
            }
        }

        return null;
    }
}
