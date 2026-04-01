<?php

namespace App\Models\Game;

use App\Enums\Game\MembershipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $toll
 * @property \App\Enums\Game\MembershipType $membership
 * @property string|null $membership_expire
 */
final class AccountData extends BaseGameModel
{
    /** @use HasFactory<\Illuminate\Database\Eloquent\Factories\Factory<self>> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'toll',
        'membership',
        'membership_expire',
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
