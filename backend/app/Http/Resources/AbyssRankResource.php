<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Game\AbyssRank;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AbyssRank */
final class AbyssRankResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rank' => $this->rank,
            'rank_pos' => $this->rank_pos,
            'ap' => $this->ap,
            'all_kill' => $this->all_kill,
            'weekly_kill' => $this->weekly_kill,
            'weekly_ap' => $this->weekly_ap,
            'player' => new PlayerResource($this->whenLoaded('player')),
        ];
    }
}
