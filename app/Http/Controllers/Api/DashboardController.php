<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Game\GetAccountPlayers;
use App\Actions\Game\Player\TeleportPlayer;
use App\Exceptions\TeleportCooldownException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountDataResource;
use App\Models\Game\Player;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use RuntimeException;

final class DashboardController extends Controller
{
    public function index(Request $request, GetAccountPlayers $getAccountPlayers): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $accountInfo = $getAccountPlayers->execute($user->aion_acc_id);

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

        try {
            $teleportPlayer->execute($player);
        } catch (TeleportCooldownException $e) {
            return response()->json([
                'message' => __('Error! It will be possible to teleport again after :time', [
                    'time' => $e->nextTeleportAt->diffForHumans(),
                ]),
                'next_teleport_at' => $e->nextTeleportAt->toIso8601String(),
            ], 422);
        } catch (InvalidArgumentException|RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => __('The player was successfully teleported!'),
        ]);
    }
}
