<?php

namespace App\Models;

use App\Models\Game\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recharge extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'player_id',
        'user_id',
        'type',
        'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
        );
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(
            related: Player::class,
            foreignKey: 'player_id',
            ownerKey: 'id',
        );
    }
}
