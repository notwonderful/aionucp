<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('gateway.limits', [
            'stripe' => [
                'min_amount' => 5.0,
                'max_amount' => 1000.0,
                'currency' => 'USD',
                'enabled' => true,
            ],
        ]);
    }
};
