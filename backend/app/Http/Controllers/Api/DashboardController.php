<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Game\Player\TeleportPlayer;
use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountDataResource;
use App\Models\Game\Player;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DashboardController extends Controller
{
    public function index(Request $request, GameServerContract $gameServer): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $accountInfo = $gameServer->getAccountWithPlayers($user->aion_acc_id);

        return response()->json([
            'data' => AccountDataResource::collection($accountInfo),
        ]);
    }

    public function teleport(Request $request, Player $player, TeleportPlayer $teleportPlayer): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        if ($player->account_id !== $user->aion_acc_id) {
            abort(403);
        }

        $teleportPlayer->execute($player, $user->id);

        return response()->json([
            'message' => __('The player was successfully teleported!'),
        ]);
    }
}
