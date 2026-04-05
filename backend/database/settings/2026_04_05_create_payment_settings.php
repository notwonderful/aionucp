<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('payment.enabled', true);
        $this->migrator->add('payment.rate_rub', 1.0);
        $this->migrator->add('payment.rate_usd', 0.01245);
        $this->migrator->add('payment.rate_eur', 0.01117);
    }
};
