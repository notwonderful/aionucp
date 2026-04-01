<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PromoCodeService
{
    /** @return Collection<int, PromoCode> */
    public function getUserPromoCodes(User $user): Collection
    {
        return PromoCode::query()
            ->where('user_id', $user->id)
            ->get();
    }

    public function getPromoCodeByCode(string $promoCode): ?PromoCode
    {
        return PromoCode::query()
            ->where('code', $promoCode)
            ->first();
    }
}
