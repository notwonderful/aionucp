<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReferralService
{
    public function getReferralAccountInfo(User $user): Builder|Referral|null
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
        $history = json_decode($referral->history, true);
        $history[] = [
            'aion_acc_id' => $user->aion_acc_id,
            'action' => 'register',
        ];

        $referral->increment('count');
        $referral->history = json_encode($history);
        $referral->save();
    }
}
