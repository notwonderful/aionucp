<?php

declare(strict_types=1);

namespace App\Models\Game;

final class WebShop extends BaseGameModel
{
    public static function usesWorldDatabase(): bool
    {
        return true;
    }

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
