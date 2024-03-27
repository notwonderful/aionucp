<?php

namespace App\Actions\Game;

use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Models\Game\AccountData;
use App\Services\AionAccountService;
use App\Services\MembershipCostCalculator;

class MembershipPurchaseAction
{
    public function __construct(
        protected MembershipCostCalculator $costCalculator,
        protected AionAccountService $accountService
    ) {}

    public function execute(AccountData $account, MembershipType $membershipType, MembershipDuration $duration): bool
    {
        $cost = $this->costCalculator->calculate($membershipType, $duration);

        $accountBalance = $this->accountService->getAccountBalance($account->id);

        if ($accountBalance < $cost) {
            return false;
        }

        $account->membership = $membershipType->value;
        $account->membership_expire = now()->addDays($duration->value);
        $account->save();

        $this->accountService->decrementAccountBalance($account->id, $cost);

        return true;
    }
}
