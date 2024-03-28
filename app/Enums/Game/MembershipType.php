<?php

namespace App\Enums\Game;

enum MembershipType: int
{
    case REGULAR = 0;
    case VIP = 1;
    case PREMIUM = 2;

    public function label(): string
    {
        return match ($this) {
            self::REGULAR => 'REGULAR',
            self::VIP => 'VIP',
            self::PREMIUM => 'PREMIUM',
        };
    }

    public function cost(): int
    {
        return config("membership.costs.{$this->name}");
    }
}
