<?php

namespace App\Actions;

use App\Enums\Currency;
use App\Http\Requests\DonateRequest;

class ConvertCurrencyAction
{
    public function execute(DonateRequest $request): float
    {
        /** @var int|float $amount */
        $amount = $request->validated('amount');
        /** @var string $currencyValue */
        $currencyValue = $request->validated('currency');
        $currency = Currency::from($currencyValue);

        return match ($currency) {
            Currency::RUB => round($amount * 10, 2),
            Currency::USD => round($amount * 0.11, 2),
            default => throw new \InvalidArgumentException("Invalid currency: {$currency->value}"),
        };
    }
}
