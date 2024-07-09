<?php

namespace App\Models\Game;

final class WebShop extends BaseGameModel
{
    protected $table = 'webshop';

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
}
