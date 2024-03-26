<?php

namespace App\Actions\Game;

use App\Services\LegionService;

class GetLegions
{
    public function __construct(
        protected LegionService $legionService
    ) {}

    public function execute()
    {
        return $this->legionService->getLegions();
    }
}
