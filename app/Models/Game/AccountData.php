<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountData extends BaseGameModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'toll',
    ];

    protected $hidden = [
        'password',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(
            related: Player::class,
            foreignKey: 'account_id',
            localKey: 'id',
        );
    }
}
