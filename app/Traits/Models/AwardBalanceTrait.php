<?php

namespace App\Traits\Models;

use App\Models\Donate;
use App\Models\User;

trait AwardBalanceTrait
{
    protected function awardBalance(Donate $donate): void
    {
        $user = User::find($donate->user_id);
        $user->increment('balance', $donate->toll);
    }
}
