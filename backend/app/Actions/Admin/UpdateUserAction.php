<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Auth\UpdateUserEmail;
use App\Contracts\GameServerContract;
use App\DataTransferObjects\AdminUpdateUserData;
use App\Models\User;

final class UpdateUserAction
{
    public function __construct(
        private readonly UpdateUserEmail $updateUserEmail,
        private readonly GameServerContract $gameServer
    ) {}

    public function execute(User $user, AdminUpdateUserData $data): User
    {
        if ($data->email !== null && $data->email !== $user->email) {
            $user->email = $data->email;
            $user->email_verified_at = null;

            $this->updateUserEmail->execute($user, $data->email);
        }

        if ($data->balance !== null) {
            $this->gameServer->setBalance($user->aion_acc_id, $data->balance);
        }

        $user->save();

        return $user;
    }
}
