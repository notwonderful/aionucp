<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'item_id',
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
