<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class CreateReferral
{
    public function __invoke(array $data): Referral
    {
        return Referral::query()->create($data);
    }
}
