<?php

namespace App\Supports\Helpers;

use App\Enums\Currency;

class CurrencyHelper
{
    public static function toString(Currency $currency): string
    {
        return $currency->value;
    }
}
