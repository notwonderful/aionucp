<?php

declare(strict_types=1);

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string $race
 * @property string $player_class
 * @property int $online
 * @property float $x
 * @property float $y
 * @property float $z
 * @property int $world_id
 */
final class Player extends BaseGameModel
{
    protected $fillable = [
        'x',
        'y',
        'z',
        'world_id',
    ];

    /** @return BelongsTo<AccountData, $this> */
    public function account(): BelongsTo
    {
        return $this->belongsTo(
            related: AccountData::class,
            foreignKey: 'account_id',
            ownerKey: 'id',
        );
    }

    /** @return HasOne<AbyssRank, $this> */
    public function abyssRank(): HasOne
    {
        return $this->hasOne(
            related: AbyssRank::class,
            foreignKey: 'player_id',
            localKey: 'id',
        );
    }
}
