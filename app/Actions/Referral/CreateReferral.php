<?php

declare(strict_types=1);

namespace App\Actions\Referral;

use App\Models\Referral;

class CreateReferral
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function __invoke(array $data): Referral
    {
        return Referral::query()->create($data);
    }
}
