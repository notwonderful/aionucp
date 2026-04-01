<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 *
 * @property string|null $slug
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            /** @var string|null $currentSlug */
            $currentSlug = $model->getAttribute('slug');
            /** @var string|null $slugSource */
            $slugSource = $model->getAttribute(self::slugFrom());
            $model->setAttribute('slug', $currentSlug ?? str($slugSource)->slug()->toString());
        });
    }

    public static function slugFrom(): string
    {
        return 'name';
    }
}
