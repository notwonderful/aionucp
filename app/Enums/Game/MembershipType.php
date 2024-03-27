<?php

namespace App\Enums\Game;

enum MembershipType: int
{
    case VIP = 1;
    case PREMIUM = 2;

    public function label(): string
    {
        return match ($this) {
            self::VIP => 'VIP',
            self::PREMIUM => 'PREMIUM',
        };
    }

    public function cost(): int
    {
        return config("membership.costs.{$this->name}");
    }
}
