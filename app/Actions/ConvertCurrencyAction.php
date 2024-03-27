<?php

namespace App\Actions;

use App\Enums\Currency;
use App\Http\Requests\DonateRequest;

class ConvertCurrencyAction
{
    public function execute(DonateRequest $request): float
    {
        $amount = $request->validated('amount');
        $currency = Currency::from($request->validated('currency'));

        return match ($currency) {
            Currency::RUB => round($amount * 10, 2),
            Currency::USD => round($amount * 0.11, 2),
            default => throw new \InvalidArgumentException("Invalid currency: {$currency->value}"),
        };
    }
}
