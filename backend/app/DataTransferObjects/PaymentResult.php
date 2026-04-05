<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class PaymentResult
{
    public function __construct(
        public string $redirectUrl,
        public string $gatewayTransactionId,
    ) {}
}
