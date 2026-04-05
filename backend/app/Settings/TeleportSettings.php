<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

final class TeleportSettings extends Settings
{
    public float $elyos_x;
    public float $elyos_y;
    public float $elyos_z;
    public int $elyos_map;

    public float $asmodians_x;
    public float $asmodians_y;
    public float $asmodians_z;
    public int $asmodians_map;

    public int $cooldown_minutes;

    public static function group(): string
    {
        return 'teleport';
    }

    /** @return array{x: float, y: float, z: float, map: int} */
    public function getCoordinates(string $race): array
    {
        $race = strtolower($race);

        return [
            'x' => $this->{"{$race}_x"},
            'y' => $this->{"{$race}_y"},
            'z' => $this->{"{$race}_z"},
            'map' => $this->{"{$race}_map"},
        ];
    }
}
