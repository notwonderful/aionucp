<?php

declare(strict_types=1);

namespace App\Enums;

enum DonationGateway: string
{
    case STRIPE = 'stripe';
    case PALLY = 'pally';

    public function label(): string
    {
        return match ($this) {
            self::STRIPE => 'Stripe',
            self::PALLY => 'Pally',
        };
    }

    public function currency(): Currency
    {
        return match ($this) {
            self::STRIPE => Currency::USD,
            self::PALLY => Currency::RUB,
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::STRIPE => '/images/gateways/stripe.svg',
            self::PALLY => '/images/gateways/pally.svg',
        };
    }
}
