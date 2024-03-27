<?php

namespace App\Enums\Game;

enum MembershipDuration: int
{
    case MONTH = 30;
    case TWO_MONTHS = 60;

    public function label(): string
    {
        return match ($this) {
            self::MONTH => __('1 month'),
            self::TWO_MONTHS => __('2 months'),
        };
    }
}
