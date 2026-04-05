<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('download.url', '#');
        $this->migrator->add('download.file_size', '~8.2 GB');
        $this->migrator->add('download.discord_url', '#');
        $this->migrator->add('download.min_requirements', [
            ['label' => 'OS', 'value' => 'Windows 7 64-bit'],
            ['label' => 'CPU', 'value' => 'Intel Core i3 / AMD FX-6300'],
            ['label' => 'RAM', 'value' => '4 GB'],
            ['label' => 'GPU', 'value' => 'GeForce GTX 660 / Radeon HD 7850'],
            ['label' => 'Storage', 'value' => '12 GB'],
            ['label' => 'Network', 'value' => '2 Mbps'],
        ]);
        $this->migrator->add('download.rec_requirements', [
            ['label' => 'OS', 'value' => 'Windows 10/11 64-bit'],
            ['label' => 'CPU', 'value' => 'Intel i5-8400 / Ryzen 5 2600'],
            ['label' => 'RAM', 'value' => '8 GB'],
            ['label' => 'GPU', 'value' => 'GeForce GTX 1060 / RX 580'],
            ['label' => 'Storage', 'value' => '12 GB SSD'],
            ['label' => 'Network', 'value' => '10 Mbps'],
        ]);
    }
};
