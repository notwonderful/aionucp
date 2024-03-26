<?php

namespace App\Services;

use App\Models\Game\Legion;
use Illuminate\Support\Facades\Cache;

class LegionService
{
    public function getLegions()
    {
        return Cache::remember('legion_ranks', 300, function () {
            return Legion::query()
                ->select('name', 'level', 'rank_pos')
                ->orderBy('rank_pos')
                ->paginate();
        });
    }
}
