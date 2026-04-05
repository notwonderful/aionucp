<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class ScheduleEntry extends Model
{
    protected $fillable = [
        'category',
        'name',
        'metadata',
        'sort_order',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    /** @param Builder<self> $query */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
