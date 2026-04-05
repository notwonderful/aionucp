<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class OnlineSnapshot extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'online_count',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'online_count' => 'integer',
            'recorded_at' => 'datetime',
        ];
    }
}
