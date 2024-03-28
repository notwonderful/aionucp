<?php

namespace App\Actions\Game;

use App\Services\AionAccountService;

class GetAccountPlayers
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    public function execute(int $account)
    {
        return $this->aionAccountService->getAccountPlayers($account);
    }
}
