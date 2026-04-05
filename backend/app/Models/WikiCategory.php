<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\WikiEntryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(WikiEntryObserver::class)]
final class WikiCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /** @return HasMany<WikiEntry, $this> */
    public function entries(): HasMany
    {
        return $this->hasMany(WikiEntry::class);
    }

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
