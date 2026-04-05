<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\MailItemLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MailItemLog */
final class MailItemLogResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'admin_name' => $this->admin?->name,
            'player_name' => $this->player_name,
            'item_id' => $this->item_id,
            'item_qty' => $this->item_qty,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
