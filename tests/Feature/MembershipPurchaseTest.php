<?php

use App\Actions\Game\MembershipPurchaseAction;
use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;
use App\Models\Game\AccountData;
use App\Services\AionAccountService;
use App\Services\MembershipCostCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can purchase membership', function () {
    $account = AccountData::factory()->create(['toll' => 1000]);
    $membershipType = MembershipType::VIP;
    $duration = MembershipDuration::MONTH;

    $costCalculator = app(MembershipCostCalculator::class);
    $accountService = app(AionAccountService::class);
    $purchaseAction = new MembershipPurchaseAction($costCalculator, $accountService);

    $success = $purchaseAction->execute($account, $membershipType, $duration);

    expect($success)->toBeTrue()
        ->and($account->fresh()->membership)->toBe($membershipType->value)
        ->and($account->fresh()->membership_expire)->toBeGreaterThan(now())
        ->and($accountService->getAccountBalance($account->id))->toBeLessThan(1000);
});

it('cannot purchase membership with insufficient balance', function () {
    $account = AccountData::factory()->create(['toll' => 10]);
    $membershipType = MembershipType::PREMIUM;
    $duration = MembershipDuration::TWO_MONTHS;

    $costCalculator = app(MembershipCostCalculator::class);
    $accountService = app(AionAccountService::class);
    $purchaseAction = new MembershipPurchaseAction($costCalculator, $accountService);

    $success = $purchaseAction->execute($account, $membershipType, $duration);

    expect($success)->toBeFalse()
        ->and($account->fresh()->membership)->toBeNull()
        ->and($account->fresh()->membership_expire)->toBeNull()
        ->and($accountService->getAccountBalance($account->id))->toBe(10);
});
