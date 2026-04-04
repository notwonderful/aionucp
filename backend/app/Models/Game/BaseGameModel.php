<?php

declare(strict_types=1);

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

abstract class BaseGameModel extends Model
{
    public $timestamps = false;

    public static function usesWorldDatabase(): bool
    {
        return false;
    }
}
