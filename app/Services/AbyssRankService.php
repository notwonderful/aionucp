<?php

namespace App\Services;

use App\Models\Game\AbyssRank;
use Illuminate\Support\Facades\Cache;

class AbyssRankService
{
    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, AbyssRank> */
    public function getAbyssRanks(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Cache::remember('abyss_ranks', 300, function () {
            return AbyssRank::with('player:id,name,race,player_class')
                ->orderByDesc('rank')
                ->paginate();
        });
    }
}
