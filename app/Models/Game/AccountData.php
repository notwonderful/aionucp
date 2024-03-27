<?php

namespace App\Models\Game;

use App\Enums\Game\MembershipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountData extends BaseGameModel
{
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

    public function players(): HasMany
    {
        return $this->hasMany(
            related: Player::class,
            foreignKey: 'account_id',
            localKey: 'id',
        );
    }
}
