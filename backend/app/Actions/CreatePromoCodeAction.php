<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\GameServerContract;
use App\DataTransferObjects\CreatePromoCodeData;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CreatePromoCodeAction
{
    public function __construct(
        private readonly GameServerContract $gameServer
    ) {}

    public function execute(User $user, CreatePromoCodeData $data): PromoCode
    {
        return DB::transaction(function () use ($user, $data) {
            $this->gameServer->ensureSufficientBalance($user->aion_acc_id, $data->toll);
            $this->gameServer->decrementBalance($user->aion_acc_id, $data->toll);

            return PromoCode::query()->create($data->toArray());
        });
    }
}
