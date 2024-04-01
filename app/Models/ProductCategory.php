<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(
            related: Product::class,
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: self::class,
            foreignKey: 'parent_id',
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            related: self::class,
            foreignKey: 'parent_id',
        );
    }
}
