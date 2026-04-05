<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbyssRankResource;
use App\Http\Resources\LegionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

final class RatingController extends Controller
{
    public function abyss(GameServerContract $gameServer): AnonymousResourceCollection
    {
        return AbyssRankResource::collection($gameServer->getAbyssRanks());
    }

    public function legion(GameServerContract $gameServer): AnonymousResourceCollection
    {
        return LegionResource::collection($gameServer->getLegionRanks());
    }

    public function stats(GameServerContract $gameServer): JsonResponse
    {
        return response()->json(['data' => $gameServer->getServerStats()]);
    }

    public function onlineHistory(): JsonResponse
    {
        return response()->json([
            'data' => Cache::get('online_history', ['daily' => [], 'hourly' => []]),
        ]);
    }
}
