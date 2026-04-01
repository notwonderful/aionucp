<?php

namespace App\Traits\Models;

use App\Models\Donate;
use App\Models\User;

/** @phpstan-ignore trait.unused */
trait AwardBalanceTrait
{
    protected function awardBalance(Donate $donate): void
    {
        $user = User::findOrFail($donate->user_id);
        $user->increment('balance', $donate->toll);
    }
}
