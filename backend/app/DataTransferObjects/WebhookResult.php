<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class WebhookResult
{
    public function __construct(
        public bool $success,
        public int $donationId,
        public string $gatewayTransactionId,
        public string $eventId,
    ) {}
}
