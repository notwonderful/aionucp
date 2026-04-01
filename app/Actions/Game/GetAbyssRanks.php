<?php

namespace App\Actions\Game;

use App\Services\AbyssRankService;

class GetAbyssRanks
{
    public function __construct(
        protected AbyssRankService $abyssRankService
    ) {}

    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \App\Models\Game\AbyssRank> */
    public function execute(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->abyssRankService->getAbyssRanks();
    }
}
