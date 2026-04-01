<?php

declare(strict_types=1);

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class BaseGameModel extends Model
{
    public $connection = 'aiondb';

    public $timestamps = false;
}
