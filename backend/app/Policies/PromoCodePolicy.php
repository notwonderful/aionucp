<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PromoCode;
use App\Models\User;

final class PromoCodePolicy
{
    public function view(User $user, PromoCode $promoCode): bool
    {
        return $user->id === $promoCode->user_id;
    }

    public function delete(User $user, PromoCode $promoCode): bool
    {
        return $user->id === $promoCode->user_id;
    }
}
