<?php

namespace App\Actions\Game;

use App\Models\Game\AccountData;
use App\Services\AionAccountService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetAccountPlayers
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    /** @return LengthAwarePaginator<int, AccountData> */
    public function execute(int $account): LengthAwarePaginator
    {
        return $this->aionAccountService->getAccountPlayers($account);
    }
}
