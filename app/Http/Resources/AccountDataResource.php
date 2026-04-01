<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Game\AccountData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AccountData */
final class AccountDataResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'toll' => $this->toll,
            'membership' => $this->membership,
            'membership_expire' => $this->membership_expire,
            'players' => PlayerResource::collection($this->whenLoaded('players')),
        ];
    }
}
