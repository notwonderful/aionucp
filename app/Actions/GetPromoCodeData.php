<?php

namespace App\Actions;

use App\Models\User;
use App\Services\PromoCodeService;
use Illuminate\Database\Eloquent\Collection;

class GetPromoCodeData
{
    public function __construct(
        protected PromoCodeService $promoCodeService
    ) {}

    public function execute(User $user): array|Collection
    {
        return $this->promoCodeService->getUserPromoCodes($user);
    }
}
