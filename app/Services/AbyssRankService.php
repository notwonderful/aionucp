<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Game\AbyssRank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AbyssRankService
{
    /** @return LengthAwarePaginator<int, AbyssRank> */
    public function getAbyssRanks(): LengthAwarePaginator
    {
        return Cache::remember('abyss_ranks', 300, function () {
            return AbyssRank::with('player:id,name,race,player_class')
                ->orderByDesc('rank')
                ->paginate();
        });
    }
}
