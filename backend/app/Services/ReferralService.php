<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Referral;
use App\Models\ReferralAction;
use App\Models\User;

final class ReferralService
{
    public function getReferralAccountInfo(User $user): ?Referral
    {
        return Referral::query()
            ->where('user_id', $user->id)
            ->withCount('actions')
            ->first();
    }

    public function setReferral(string $refCode, User $user): void
    {
        $referral = Referral::where('code', $refCode)->first();

        if ($referral) {
            ReferralAction::create([
                'referral_id' => $referral->id,
                'aion_acc_id' => $user->aion_acc_id,
                'action' => 'register',
            ]);
        }
    }
}
