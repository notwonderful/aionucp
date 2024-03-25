<?php

namespace App\Actions\Auth;

use App\Services\AionAccountService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    public function handle(Authenticatable $user, string $newPassword): void
    {
        DB::transaction(function () use ($user, $newPassword) {
            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            $this->aionAccountService->updatePassword($user->aion_acc_id, $newPassword);
        });
    }
}
