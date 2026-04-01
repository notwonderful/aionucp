<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Referral;
use App\Models\User;

class ReferralService
{
    public function getReferralAccountInfo(User $user): ?Referral
    {
        return Referral::query()
            ->where('user_id', $user->id)
            ->first();
    }

    public function setReferral(string $ref_code, User $user): void
    {
        $referral = $this->getReferral($ref_code);

        if ($referral) {
            $this->updateReferral($referral, $user);
            session()->forget('ref_code');
        }
    }

    private function getReferral(string $ref_code): ?Referral
    {
        return Referral::where('code', $ref_code)->first();
    }

    private function updateReferral(Referral $referral, User $user): void
    {
        /** @var array<int, array<string, mixed>> $history */
        $history = json_decode($referral->history ?? '[]', true);
        $history[] = [
            'aion_acc_id' => $user->aion_acc_id,
            'action' => 'register',
        ];

        $referral->increment('count');
        $referral->history = json_encode($history) ?: '[]';
        $referral->save();
    }
}
