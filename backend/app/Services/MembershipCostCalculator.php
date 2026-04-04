<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;

final class MembershipCostCalculator
{
    public function calculate(MembershipType $membershipType, MembershipDuration $duration): int
    {
        $baseCost = $membershipType->cost();

        return (int) ($baseCost * ($duration->value / 30));
    }
}
