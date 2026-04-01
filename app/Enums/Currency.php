<?php

declare(strict_types=1);

namespace App\Enums;

enum Currency: string
{
    case RUB = 'RUB';
    case USD = 'USD';
    case EUR = 'EUR';

    public function getSymbol(): string
    {
        return match ($this) {
            self::RUB => '₽',
            self::USD => '$',
            self::EUR => '€',
        };
    }
}
