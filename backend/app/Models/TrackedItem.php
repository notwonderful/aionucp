<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class TrackedItem extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'item_unique_id';

    protected $fillable = [
        'item_unique_id',
        'item_id',
        'item_owner',
        'item_count',
        'enchant',
        'item_creator',
        'last_owner_name',
        'last_owner_account',
        'is_deleted',
        'first_seen_at',
        'last_changed_at',
    ];

    protected function casts(): array
    {
        return [
            'item_unique_id' => 'integer',
            'item_id' => 'integer',
            'item_owner' => 'integer',
            'item_count' => 'integer',
            'enchant' => 'integer',
            'is_deleted' => 'boolean',
            'first_seen_at' => 'datetime',
            'last_changed_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'item_unique_id';
    }
}
