<?php

namespace App\Actions\Game;

use App\Services\AionAccountService;

class GetAccountPlayers
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \App\Models\Game\AccountData> */
    public function execute(int $account): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->aionAccountService->getAccountPlayers($account);
    }
}
