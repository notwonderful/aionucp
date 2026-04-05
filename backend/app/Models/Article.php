<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(ArticleObserver::class)]
final class Article extends Model
{
    use HasFactory;
    use HasTranslatableSlug;
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['title', 'slug', 'excerpt', 'body'];

    protected $fillable = [
        'title',
        'slug',
        'tag',
        'excerpt',
        'body',
        'image',
        'published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true)->whereNotNull('published_at');
    }
}
