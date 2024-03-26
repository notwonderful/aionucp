<?php

namespace App\Actions\Auth;

use App\Services\AionAccountService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class UpdateUserEmail
{
    public function __construct(
        protected AionAccountService $aionAccountService
    ) {}

    public function handle(Authenticatable $user, string $newEmail): void
    {
        DB::transaction(function () use ($user, $newEmail) {
            $user->update([
                'email' => $newEmail,
            ]);

            $this->aionAccountService->updateEmail($user->aion_acc_id, $newEmail);
        });
    }
}
