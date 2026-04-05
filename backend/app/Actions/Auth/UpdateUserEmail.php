<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Contracts\GameServerContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class UpdateUserEmail
{
    public function __construct(
        private readonly GameServerContract $gameServer
    ) {}

    public function execute(User $user, string $newEmail): void
    {
        DB::transaction(function () use ($user, $newEmail) {
            $user->update([
                'email' => $newEmail,
            ]);

            $this->gameServer->updateEmail($user->aion_acc_id, $newEmail);
        });
    }
}
