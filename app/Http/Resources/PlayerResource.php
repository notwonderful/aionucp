<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Game\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Player */
final class PlayerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'race' => $this->race,
            'player_class' => $this->player_class,
            'online' => $this->online,
        ];
    }
}
