<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

final class AnnouncementSettings extends Settings
{
    public bool $enabled;

    public string $text;

    public string $link_text;

    public string $link_url;

    public static function group(): string
    {
        return 'announcement';
    }
}
