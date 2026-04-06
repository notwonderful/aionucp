<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ItemTrackerLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'item_unique_id',
        'item_id',
        'old_owner_id',
        'old_owner_name',
        'old_owner_account',
        'new_owner_id',
        'new_owner_name',
        'new_owner_account',
        'event_type',
        'logged_at',
    ];

    protected function casts(): array
    {
        return [
            'item_unique_id' => 'integer',
            'item_id' => 'integer',
            'old_owner_id' => 'integer',
            'new_owner_id' => 'integer',
            'logged_at' => 'datetime',
        ];
    }
}
