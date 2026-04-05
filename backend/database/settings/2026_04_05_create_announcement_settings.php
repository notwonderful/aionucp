<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('announcement.enabled', true);
        $this->migrator->add('announcement.text', 'Patch 3.9.7 is live — Dredgion fixes, class balance, new events.');
        $this->migrator->add('announcement.link_text', 'Read more');
        $this->migrator->add('announcement.link_url', '#');
    }
};
