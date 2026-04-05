<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('payment.bonus_tiers', [
            ['min_toll' => 500, 'bonus_percent' => 5],
            ['min_toll' => 1000, 'bonus_percent' => 10],
            ['min_toll' => 2500, 'bonus_percent' => 15],
            ['min_toll' => 5000, 'bonus_percent' => 20],
        ]);
    }
};
