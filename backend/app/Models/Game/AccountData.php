<?php

declare(strict_types=1);

namespace App\Models\Game;

use App\Enums\Game\MembershipType;
use Database\Factories\Game\AccountDataFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $toll
 * @property MembershipType $membership
 * @property string|null $expire
 * @property-read string|null $membership_expire
 */
final class AccountData extends BaseGameModel
{
    /** @use HasFactory<AccountDataFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'password',
        'toll',
        'membership',
        'expire',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'membership' => MembershipType::class,
        ];
    }

    /** @return Attribute<string|null, never> */
    protected function membershipExpire(): Attribute
    {
        return Attribute::get(fn ($value, array $attributes) => $attributes['expire'] ?? null);
    }

    /** @return HasMany<Player, $this> */
    public function players(): HasMany
    {
        return $this->hasMany(
            related: Player::class,
            foreignKey: 'account_id',
            localKey: 'id',
        );
    }
}
