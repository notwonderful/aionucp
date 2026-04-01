<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Game\GetAbyssRanks;
use App\Actions\Game\GetLegions;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbyssRankResource;
use App\Http\Resources\LegionResource;
use Illuminate\Http\JsonResponse;

final class RatingController extends Controller
{
    public function abyss(GetAbyssRanks $getAbyssRanks): JsonResponse
    {
        $abyssRanks = $getAbyssRanks->execute();

        return response()->json(
            AbyssRankResource::collection($abyssRanks)->response()->getData(true),
        );
    }

    public function legion(GetLegions $getLegions): JsonResponse
    {
        $legions = $getLegions->execute();

        return response()->json(
            LegionResource::collection($legions)->response()->getData(true),
        );
    }
}
