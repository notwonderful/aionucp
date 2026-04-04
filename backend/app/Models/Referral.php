<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ReferralFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Referral extends Model
{
    /** @use HasFactory<ReferralFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'earned',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
        );
    }

    /** @return HasMany<ReferralAction, $this> */
    public function actions(): HasMany
    {
        return $this->hasMany(
            related: ReferralAction::class,
        );
    }
}
