<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Referral;
use Illuminate\Support\Str;

class CreateReferralLink
{
    public function handle(Registered $event): void
    {
        $user = $event->user;
        $referralCode = md5($user->name . Str::random(5));

        Referral::create([
            'code' => $referralCode,
            'user_id' => $user->id,
        ]);
    }
}
