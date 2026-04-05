<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
final class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'toll' => $this->toll,
            'item_id' => $this->item_id,
            'item_qty' => $this->item_qty,
            'image_url' => $this->image_url,
            'sales_count' => $this->sales_count,
            'category_id' => $this->category_id,
            'category' => new ProductCategoryResource($this->whenLoaded('category')),
            'translations' => $this->when(
                $request->routeIs('admin.*'),
                fn () => [
                    'name' => $this->getTranslations('name'),
                    'description' => $this->getTranslations('description'),
                ],
            ),
        ];
    }
}
