<?php

namespace App\Actions;

use App\Models\Referral;
use App\Models\User;
use App\Services\ReferralService;
use Illuminate\Database\Eloquent\Builder;

class GetReferralData
{
    public function __construct(
        protected ReferralService $referralService
    ) {}

    public function execute(User $user): Builder|Referral|null
    {
        return $this->referralService->getReferralAccountInfo($user);
    }
}
