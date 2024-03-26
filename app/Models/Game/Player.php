<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Player extends BaseGameModel
{
    public function account(): BelongsTo
    {
        return $this->belongsTo(
            related: AccountData::class,
            foreignKey: 'account_id',
            ownerKey: 'id',
        );
    }

    public function abyssRank(): HasOne
    {
        return $this->hasOne(
            related: AbyssRank::class,
            foreignKey: 'player_id',
            localKey: 'id',
        );
    }
}
