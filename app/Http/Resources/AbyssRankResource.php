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
            'player' => new PlayerResource($this->whenLoaded('player')),
        ];
    }
}
