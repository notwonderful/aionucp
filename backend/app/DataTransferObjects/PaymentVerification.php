<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Enums\Currency;

final readonly class PaymentVerification
{
    public function __construct(
        public bool $paid,
        public int $amount,
        public Currency $currency,
        public string $status,
    ) {}
}
