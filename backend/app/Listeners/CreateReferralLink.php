<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

final class CreateReferralLink
{
    public function handle(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        Referral::query()->create([
            'code' => md5($user->name.Str::random(5)),
            'user_id' => $user->id,
        ]);
    }
}
