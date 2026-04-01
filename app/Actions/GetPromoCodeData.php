<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\PromoCode;
use App\Models\User;
use App\Services\PromoCodeService;
use Illuminate\Database\Eloquent\Collection;

class GetPromoCodeData
{
    public function __construct(
        protected PromoCodeService $promoCodeService
    ) {}

    /** @return Collection<int, PromoCode> */
    public function execute(User $user): Collection
    {
        return $this->promoCodeService->getUserPromoCodes($user);
    }
}
