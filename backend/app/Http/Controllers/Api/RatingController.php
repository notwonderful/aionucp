<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Contracts\GameServerContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbyssRankResource;
use App\Http\Resources\LegionResource;
use App\Models\Game\Player;
use App\Services\GameServer\GameServerManager;
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

    public function stats(GameServerManager $manager): JsonResponse
    {
        $manager->current(); // ensure connections are initialized

        $server = Cache::flexible('server_stats', [60, 300], function () use ($manager) {
            $serverModel = \App\Models\Server::where('is_default', true)->first();
            $conn = $manager->worldConnectionName($serverModel);
            $online = \DB::connection($conn)->selectOne('SELECT COUNT(*) as cnt FROM players WHERE online = 1');
            $total = \DB::connection($conn)->selectOne('SELECT COUNT(*) as cnt FROM players');
            $races = \DB::connection($conn)->select('SELECT race, COUNT(*) as cnt FROM players GROUP BY race');
            $classes = \DB::connection($conn)->select('SELECT player_class, COUNT(*) as cnt FROM players GROUP BY player_class ORDER BY cnt DESC');

            return [
                'online' => $online->cnt,
                'total_characters' => $total->cnt,
                'races' => collect($races)->mapWithKeys(fn ($r) => [$r->race => $r->cnt]),
                'classes' => collect($classes)->mapWithKeys(fn ($c) => [$c->player_class => $c->cnt]),
            ];
        });

        return response()->json(['data' => $server]);
    }
}
