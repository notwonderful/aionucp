<?php

declare(strict_types=1);

namespace App\Enums;

enum DonationGateway: string
{
    case STRIPE = 'stripe';

    public function label(): string
    {
        return match ($this) {
            self::STRIPE => 'Stripe',
        };
    }

    public function currency(): Currency
    {
        return match ($this) {
            self::STRIPE => Currency::USD,
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::STRIPE => '/images/gateways/stripe.svg',
        };
    }
}
