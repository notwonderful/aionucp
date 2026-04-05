<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\WikiEntryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(WikiEntryObserver::class)]
final class WikiEntry extends Model
{
    protected $fillable = [
        'wiki_category_id',
        'type',
        'content',
        'sort_order',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /** @return BelongsTo<WikiCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WikiCategory::class, 'wiki_category_id');
    }

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
