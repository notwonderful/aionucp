<?php

declare(strict_types=1);

namespace App\Actions\Game;

use App\Models\Game\Legion;
use App\Services\LegionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetLegions
{
    public function __construct(
        protected LegionService $legionService
    ) {}

    /** @return LengthAwarePaginator<int, Legion> */
    public function execute(): LengthAwarePaginator
    {
        return $this->legionService->getLegions();
    }
}
