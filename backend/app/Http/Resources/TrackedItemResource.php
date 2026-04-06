<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\TrackedItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TrackedItem */
final class TrackedItemResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'item_unique_id' => $this->item_unique_id,
            'item_id' => $this->item_id,
            'item_owner' => $this->item_owner,
            'item_count' => $this->item_count,
            'enchant' => $this->enchant,
            'item_creator' => $this->item_creator,
            'last_owner_name' => $this->last_owner_name,
            'last_owner_account' => $this->last_owner_account,
            'is_deleted' => $this->is_deleted,
            'first_seen_at' => $this->first_seen_at?->toISOString(),
            'last_changed_at' => $this->last_changed_at?->toISOString(),
        ];
    }
}
