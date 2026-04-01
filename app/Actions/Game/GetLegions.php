<?php

namespace App\Actions\Game;

use App\Services\LegionService;

class GetLegions
{
    public function __construct(
        protected LegionService $legionService
    ) {}

    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \App\Models\Game\Legion> */
    public function execute(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->legionService->getLegions();
    }
}
