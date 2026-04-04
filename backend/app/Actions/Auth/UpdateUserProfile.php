<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DataTransferObjects\ProfileUpdateData;
use App\Models\User;

final class UpdateUserProfile
{
    public function __construct(
        protected UpdateUserEmail $updateUserEmail
    ) {}

    public function execute(User $user, ProfileUpdateData $data): User
    {
        $emailChanged = $data->email !== $user->email;

        $user->email = $data->email;

        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();

            $this->updateUserEmail->execute($user, $data->email);
        } else {
            $user->save();
        }

        return $user->fresh() ?? $user;
    }
}
