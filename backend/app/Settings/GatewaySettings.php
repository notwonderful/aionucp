<?php

declare(strict_types=1);

namespace App\Settings;

use App\Enums\DonationGateway;
use Spatie\LaravelSettings\Settings;

final class GatewaySettings extends Settings
{
    public array $limits;

    public static function group(): string
    {
        return 'gateway';
    }

    /** @return array{min_amount: float, max_amount: float, currency: string, enabled: bool}|null */
    public function getGatewayLimits(DonationGateway $gateway): ?array
    {
        return $this->limits[$gateway->value] ?? null;
    }

    public function isGatewayEnabled(DonationGateway $gateway): bool
    {
        $limits = $this->getGatewayLimits($gateway);

        return $limits !== null && $limits['enabled'];
    }
}
