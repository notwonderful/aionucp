<?php

namespace App\Models\Game;

final class Inventory extends BaseGameModel
{
    protected $table = 'inventory';

    protected $primaryKey = 'item_unique_id';

    protected $fillable = [
        'item_unique_id',
        'item_id',
        'item_skin',
        'item_count',
        'item_owner',
        'item_creator',
        'item_location',
        'enchant',
        'authorize',
    ];
}
