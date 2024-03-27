<?php

namespace App\Services;

use App\Enums\Game\MembershipDuration;
use App\Enums\Game\MembershipType;

class MembershipCostCalculator
{
    public function calculate(MembershipType $membershipType, MembershipDuration $duration): int
    {
        $baseCost = $membershipType->cost();

        return $baseCost * ($duration->value / 30);
    }
}
