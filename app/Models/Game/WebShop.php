<?php

namespace App\Models\Game;

class WebShop extends BaseGameModel
{
    protected $fillable = [
        'recipient',
        'item_desc',
        'item_id',
        'count',
        'toll',
        'balanced',
        'send',
        'shop_type',
        'time_received',
    ];

    protected function casts(): array
    {
        return [
            'time_received' => 'datetime',
        ];
    }

}
