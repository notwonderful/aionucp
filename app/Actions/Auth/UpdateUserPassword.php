<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Services\AionAccountService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    public function handle(User $user, string $newPassword): void
    {
        DB::transaction(function () use ($user, $newPassword) {
            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            $this->aionAccountService->updatePassword($user->aion_acc_id, $newPassword);
        });
    }
}
