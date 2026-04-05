<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\Enums\DonationGateway;

final class PaymentGatewayFactory
{
    public function __construct(
        private readonly StripeGateway $stripeGateway,
    ) {}

    public function make(DonationGateway $gateway): PaymentGateway
    {
        return match ($gateway) {
            DonationGateway::STRIPE => $this->stripeGateway,
        };
    }
}
