<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TwoFactorMethod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TwoFactorAuthentication extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'secret',
        'recovery_codes',
        'enabled',
        'verified_at',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'method' => TwoFactorMethod::class,
            'secret' => 'encrypted',
            'recovery_codes' => 'encrypted:array',
            'enabled' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @param Builder<self> $query */
    public function scopeEnabled(Builder $query): void
    {
        $query->where('enabled', true);
    }
}
