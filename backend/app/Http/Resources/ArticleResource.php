<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Article */
final class ArticleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'tag' => $this->tag,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'image_url' => $this->image_url,
            'published' => $this->published,
            'published_at' => $this->published_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'translations' => $this->when(
                $request->routeIs('admin.*'),
                fn () => [
                    'title' => $this->getTranslations('title'),
                    'excerpt' => $this->getTranslations('excerpt'),
                    'body' => $this->getTranslations('body'),
                ],
            ),
        ];
    }
}
