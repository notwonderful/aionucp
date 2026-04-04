<?php

declare(strict_types=1);

namespace App\Models\Game;

/**
 * @property string $name
 * @property int $level
 * @property int $rank_pos
 */
final class Legion extends BaseGameModel
{
    public static function usesWorldDatabase(): bool
    {
        return true;
    }
}
