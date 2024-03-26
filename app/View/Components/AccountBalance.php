<?php

namespace App\View\Components;

use App\Services\AionAccountService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccountBalance extends Component
{
    public int $balance;

    public function __construct(AionAccountService $aionAccountService)
    {
        $this->balance = $aionAccountService->getAccountBalance(auth()->user()->aion_acc_id);
    }

    public function render(): View
    {
        return view('components.account-balance');
    }
}
