<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\ItemTrackerLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ItemTrackerLog */
final class ItemTrackerLogResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item_unique_id' => $this->item_unique_id,
            'item_id' => $this->item_id,
            'old_owner_id' => $this->old_owner_id,
            'old_owner_name' => $this->old_owner_name,
            'old_owner_account' => $this->old_owner_account,
            'new_owner_id' => $this->new_owner_id,
            'new_owner_name' => $this->new_owner_name,
            'new_owner_account' => $this->new_owner_account,
            'event_type' => $this->event_type,
            'logged_at' => $this->logged_at?->toISOString(),
        ];
    }
}
