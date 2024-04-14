<?php

namespace App\Listeners;

use App\Actions\Referral\CreateReferral;
use App\Actions\Referral\GenerateReferralCode;
use Illuminate\Auth\Events\Registered;

final readonly class CreateReferralLink
{
    public function __construct(
        private GenerateReferralCode $referralCodeGenerator,
        private CreateReferral $createReferral
    ) {}

    public function handle(Registered $event): void
    {
        $user = $event->user;
        $referralCode = ($this->referralCodeGenerator)($user->name);

        ($this->createReferral)([
            'code' => $referralCode,
            'user_id' => $user->id,
        ]);
    }
}
