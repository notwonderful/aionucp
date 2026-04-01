<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DataTransferObjects\UserData;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\AionAccountService;
use App\Services\ReferralService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class RegisterUser
{
    public function __construct(
        protected AionAccountService $aionAccountService,
        protected ReferralService $referralService
    ) {}

    public function handle(UserData $userData, ?string $refCode = null): User
    {
        return DB::transaction(function () use ($userData, $refCode) {
            $aionAccountId = $this->aionAccountService->create($userData);

            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'password' => $userData->password,
                'aion_acc_id' => $aionAccountId,
            ])->assignRole(UserRole::MEMBER);

            event(new Registered($user));

            Auth::login($user);

            if ($refCode !== null) {
                $this->referralService->setReferral($refCode, $user);
            }

            return $user;
        });
    }
}
