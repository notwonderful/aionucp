<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

final class DownloadSettings extends Settings
{
    public string $url;

    public string $file_size;

    public string $discord_url;

    public array $min_requirements;

    public array $rec_requirements;

    public static function group(): string
    {
        return 'download';
    }
}
