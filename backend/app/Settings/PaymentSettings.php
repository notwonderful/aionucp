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

    public array $bonus_tiers;

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

    public function getBonusPercent(int $toll): int
    {
        $sorted = $this->bonus_tiers;
        usort($sorted, static fn (array $a, array $b): int => $a['min_toll'] <=> $b['min_toll']);

        $percent = 0;

        foreach ($sorted as $tier) {
            if ($toll >= $tier['min_toll']) {
                $percent = $tier['bonus_percent'];
            }
        }

        return $percent;
    }

    public function calculateBonusToll(int $toll): int
    {
        $percent = $this->getBonusPercent($toll);

        return $percent > 0 ? (int) floor($toll * $percent / 100) : 0;
    }
}
