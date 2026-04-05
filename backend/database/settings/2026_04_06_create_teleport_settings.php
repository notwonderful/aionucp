<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('teleport.elyos_x', 1321.8889);
        $this->migrator->add('teleport.elyos_y', 1512.0398);
        $this->migrator->add('teleport.elyos_z', 567.9196);
        $this->migrator->add('teleport.elyos_map', 110010000);

        $this->migrator->add('teleport.asmodians_x', 1662.9128);
        $this->migrator->add('teleport.asmodians_y', 1401.1302);
        $this->migrator->add('teleport.asmodians_z', 194.66542);
        $this->migrator->add('teleport.asmodians_map', 120010000);

        $this->migrator->add('teleport.cooldown_minutes', 60);
    }
};
