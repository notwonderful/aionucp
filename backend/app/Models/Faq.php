<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\FaqObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[ObservedBy(FaqObserver::class)]
final class Faq extends Model
{
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['question', 'answer'];

    protected $fillable = [
        'question',
        'answer',
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

    /** @param Builder<self> $query */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }
}
