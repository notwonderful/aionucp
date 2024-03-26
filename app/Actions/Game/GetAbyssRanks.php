<?php

namespace App\Actions\Game;

use App\Services\AbyssRankService;

class GetAbyssRanks
{
    public function __construct(
        protected AbyssRankService $abyssRankService
    ) {}

    public function execute()
    {
        return $this->abyssRankService->getAbyssRanks();
    }
}
