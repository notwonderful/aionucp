<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\GameServerContract;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class ActivatePromoCodeAction
{
    public function __construct(
        protected GameServerContract $gameServer
    ) {}

    public function execute(User $user, string $code): void
    {
        DB::transaction(function () use ($user, $code) {
            $promoCode = PromoCode::query()
                ->where('code', $code)
                ->lockForUpdate()
                ->firstOrFail();

            $this->gameServer->incrementBalance($user->aion_acc_id, $promoCode->toll);
            $promoCode->delete();
        });
    }
}
