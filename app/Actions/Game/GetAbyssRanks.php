<?php

namespace App\Actions\Game;

use App\Models\Game\AbyssRank;
use App\Services\AbyssRankService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetAbyssRanks
{
    public function __construct(
        protected AbyssRankService $abyssRankService
    ) {}

    /** @return LengthAwarePaginator<int, AbyssRank> */
    public function execute(): LengthAwarePaginator
    {
        return $this->abyssRankService->getAbyssRanks();
    }
}
