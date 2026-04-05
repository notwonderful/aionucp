<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Contracts\GameServerContract;
use App\DataTransferObjects\UserData;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\ReferralService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class RegisterUser
{
    public function __construct(
        private readonly GameServerContract $gameServer,
        private readonly ReferralService $referralService
    ) {}

    public function execute(UserData $userData, ?string $refCode = null): User
    {
        $user = DB::transaction(function () use ($userData, $refCode) {
            $aionAccountId = $this->gameServer->createAccount($userData);

            $user = User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'password' => $userData->password,
                'aion_acc_id' => $aionAccountId,
            ])->assignRole(UserRole::MEMBER);

            if ($refCode !== null) {
                $this->referralService->setReferral($refCode, $user);
            }

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        return $user;
    }
}
