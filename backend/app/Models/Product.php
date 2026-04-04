<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

final class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasTranslatableSlug;
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['name', 'slug', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'item_id',
        'item_qty',
        'sales_count',
        'toll',
        'image',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image ?? '');
    }

    /** @return BelongsTo<ProductCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: ProductCategory::class,
        );
    }
}
