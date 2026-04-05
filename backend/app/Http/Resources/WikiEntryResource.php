<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\WikiEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin WikiEntry */
final class WikiEntryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'wiki_category_id' => $this->wiki_category_id,
            'category' => $this->whenLoaded('category', fn () => new WikiCategoryResource($this->category)),
            'type' => $this->type,
            'content' => $this->content,
            'sort_order' => $this->sort_order,
            'published' => $this->published,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
