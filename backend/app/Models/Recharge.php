<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Game\Player;
use Database\Factories\RechargeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Recharge extends Model
{
    /** @use HasFactory<RechargeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'player_id',
        'user_id',
        'type',
        'date',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
        );
    }

    /** @return BelongsTo<Player, $this> */
    public function player(): BelongsTo
    {
        return $this->belongsTo(
            related: Player::class,
        );
    }
}
