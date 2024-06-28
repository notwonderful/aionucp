<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

final class Product extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'item_id',
        'item_qty',
        'sales_count',
        'toll',
        'image',
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: ProductCategory::class,
        );
    }
}
