<?php

namespace App\Models\Game;

use App\Enums\Game\AbyssRankName;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AbyssRank extends BaseGameModel
{
    protected $table = 'abyss_rank';

    protected $primaryKey = 'player_id';

    public function player(): BelongsTo
    {
        return $this->belongsTo(
            related: Player::class,
            foreignKey: 'player_id',
            ownerKey: 'id',
        );
    }

    protected function casts(): array
    {
        return [
            'rank' => AbyssRankName::class,
        ];
    }
}
