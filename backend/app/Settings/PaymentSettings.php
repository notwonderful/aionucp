<?php

declare(strict_types=1);

namespace App\Settings;

use App\Enums\Currency;
use Spatie\LaravelSettings\Settings;

final class PaymentSettings extends Settings
{
    public bool $enabled;

    public float $rate_rub;

    public float $rate_usd;

    public float $rate_eur;

    public static function group(): string
    {
        return 'payment';
    }

    public function getRate(Currency $currency): float
    {
        return match ($currency) {
            Currency::RUB => $this->rate_rub,
            Currency::USD => $this->rate_usd,
            Currency::EUR => $this->rate_eur,
        };
    }

    public function tollToMoney(int $toll, Currency $currency): int
    {
        return (int) round($toll * $this->getRate($currency) * 100);
    }
}
