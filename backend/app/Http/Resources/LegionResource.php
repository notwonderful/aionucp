<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Game\Legion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Legion */
final class LegionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'level' => $this->level,
            'rank_pos' => $this->rank_pos,
        ];
    }
}
