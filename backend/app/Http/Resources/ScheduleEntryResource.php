<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ScheduleEntry */
final class ScheduleEntryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'name' => $this->name,
            'metadata' => $this->metadata,
            'sort_order' => $this->sort_order,
            'published' => $this->published,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
