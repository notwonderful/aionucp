<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Contracts\GameServerContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UpdateUserPassword
{
    public function __construct(
        private readonly GameServerContract $gameServer
    ) {}

    public function execute(User $user, string $newPassword): void
    {
        DB::transaction(function () use ($user, $newPassword) {
            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            $this->gameServer->updatePassword($user->aion_acc_id, $newPassword);
        });
    }
}
