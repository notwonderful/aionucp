<?php

declare(strict_types=1);

namespace App\Actions\Game;

use App\Contracts\GameServerContract;
use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Exceptions\InsufficientBalanceException;
use App\Models\Game\AccountData;
use App\Services\MembershipCostCalculator;
use Illuminate\Support\Facades\DB;

final class MembershipPurchaseAction
{
    public function __construct(
        private readonly MembershipCostCalculator $costCalculator,
        private readonly GameServerContract $gameServer
    ) {}

    /**
     * @throws InsufficientBalanceException
     */
    public function execute(AccountData $account, MembershipType $membershipType, MembershipDuration $duration): void
    {
        $cost = $this->costCalculator->calculate($membershipType, $duration);

        DB::transaction(function () use ($account, $membershipType, $duration, $cost) {
            $this->gameServer->ensureSufficientBalance($account->id, $cost);

            /** @var AccountData $lockedAccount */
            $lockedAccount = AccountData::query()
                ->where('id', $account->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedAccount->membership = $membershipType;
            $lockedAccount->membership_expire = now()->addDays($duration->value)->toDateTimeString();
            $lockedAccount->save();

            $this->gameServer->decrementBalance($account->id, $cost);
        });
    }
}
