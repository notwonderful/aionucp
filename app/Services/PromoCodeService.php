<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PromoCodeService
{
    public function getUserPromoCodes(User $user): Collection|array
    {
        return PromoCode::query()
            ->where('user_id', $user->id)
            ->get();
    }

    public function getPromoCodeByCode(string $promoCode): Builder|PromoCode|null
    {
        return PromoCode::query()
            ->where('code', $promoCode)
            ->first();
    }
}
