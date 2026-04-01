<?php

namespace App\Actions;

use App\Models\Referral;
use App\Models\User;
use App\Services\ReferralService;

class GetReferralData
{
    public function __construct(
        protected ReferralService $referralService
    ) {}

    public function execute(User $user): ?Referral
    {
        return $this->referralService->getReferralAccountInfo($user);
    }
}
